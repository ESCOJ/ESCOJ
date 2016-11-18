<?php 

namespace ESCOJ\EscojLB;
use Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use ESCOJ\Exceptions\MemoryLimitException;

class Grader{

    //vars used to compiling and executing
    private static $GCC = "/usr/bin/gcc -std=c99 -w ";
    private static $GCCPLUSPLUS = "/usr/bin/g++ -w ";
    private static $JAVAC = "javac ";
    private static $JAVA = "java -Djava.compiler=NONE -cp ";
    private static $PYTHON = "python ";

    //vars used to store the limits to evaluate
    private static $SIZE_LIMIT = 0;
    private static $TIME_LIMIT = 0;
    private static $MEMORY_LIMIT = 0;
    private static $TOTAL_TIME_LIMIT = 0; 

    //indicates where we will store the temporary files created when we compiling and executing
    private static $STORAGE_PATH = '';

    //indicates where are stored the datasets of the submitted problem
    private static $DATASET_PROBLEM_PATH = '';

    //array used to store all information about the current submit
    private static $RESULTS = array();

    //var that indicates the maximum time in seconds that the server runs and wait a process
	private static $LIMIT_EXCECUTION_SERVER_TIME = 0;

    //array used to store all the restricted functions in order to check tehe RF verdict
    private static $RESTRICTED_FUNCTION = array('thread','exec','system','fork','pthread_t','pthread_create','fopen');
	
    //var that indicates the amount of loops executed in order to obtain a average time and memory occupied for the current submit
    private static $LOOPS_TO_TIME =  10;

    //var used to redirect the stderroutput to stdoutput
    private static $REDIRECT_OUTPUT = " 2>&1 ";

    //sentence used to retrieve the time used for the solution
    private static $TIME_AND_MEMORY_SENTENCE = "/usr/bin/time -f '%e %M' ";

    //array used to asign a verdict to the current submit	
	private static $VERDICTS = array(
        "JDG" => "Judging",
        "UQD" => "Unqualified",
        "IE"  => "Internal Error",
        "SLE"  => "Size Limit Exceeded",
        "RF"  => "Restricted Function",
        "CE"  => "Compilation Error",
        "RTE" => "Runtime Error",
        "TLE" => "Time Limit Exceeded",
        "MLE" => "Memory Limit Exceeded",
        "OLE" => "Output Limit Exceeded", //Output limit currently is 64mb
        "PE"  => "Presentation Error",
        "WA"  => "Wrong Answer",
        "AC"  => "Accepted"
    );


	static function evaluateCode($file, $language, $problem_id, $id_user, $limits, $nickname_user){
        
        //Limits of this submission considering the problem and language submitted         
        self::$MEMORY_LIMIT     = isset($limits['ml'])   ? $limits['ml']:0;
        self::$SIZE_LIMIT       = isset($limits['sl'])   ? $limits['sl']:0;
        self::$TIME_LIMIT       = isset($limits['tlpc']) ? $limits['tlpc']:0;
        self::$TOTAL_TIME_LIMIT = isset($limits['ttl'])  ? $limits['ttl']:0;

        self::buildResultArray($language, $problem_id, $id_user);

        $realpath_of_submitted_file = storage_path('judgments/'.$file);
        self::$STORAGE_PATH = dirname($realpath_of_submitted_file);
        self::$DATASET_PROBLEM_PATH = storage_path() . "/datasets/problem_".$problem_id.'/';;

        //Size Limit Exceeded
        if( self::evaluateSizeLimitExceeded($realpath_of_submitted_file) )
            return self::$RESULTS;

        //Restricted Function
        if( self::evaluateRestrictedFunction($realpath_of_submitted_file) )
            return self::$RESULTS;
      
		switch ($language) {
			case '1':
				# C
				$output_file = self::$STORAGE_PATH .'/'.$nickname_user.'_'.$id_user."_".$problem_id.".out";

                $sentence_to_compile = self::$GCC . $realpath_of_submitted_file . " -o " . $output_file . " -static -lm";

                //Compilation Error
                if( self::evaluateCompilationError($sentence_to_compile) ){
                    self::deleteCode($realpath_of_submitted_file);
                    return self::$RESULTS;                   
                }
                /*else if( self::evaluateRuntimeError($output_file) ){
                    self::deleteCode($realpath_of_submitted_file);
                     return self::$RESULTS;
                }*/
                else if( self::evaluateTimeLimitExceededMemoryLimitExceededRuntimeError($output_file) ){
                    self::deleteCode($realpath_of_submitted_file);
                    return self::$RESULTS;
                }
                else{
                    self::evaluateWA($output_file,$problem_id,$language,$id_user);
                    self::deleteCode($realpath_of_submitted_file);
                    return self::$RESULTS;
                }
                dd('no valio pa verga');
            
                self::deleteExecutableforC($output_file);

                self::deleteCode($realpath_of_submitted_file);
                return self::$RESULTS;

				break;
			case '2':
				# C++
				$output_file = $nickname_user.'_'.$id_user."_".$problem_id.".out";

                $sentence_to_compile = self::$GCCPLUSPLUS . $realpath_of_submitted_file . " -o " . self::$STORAGE_PATH . $output_file .self::$OPTIMIZED_COMPILATION.self::$REDIRECT_OUTPUT;

                //exec($sentence_to_compile,$output1);
                exec('/usr/bin/g++ /home/vagrant/Code/ESCOJ/storage/Programitas/a_plus_b.c -o /home/vagrant/Code/ESCOJ/storage/Programitas/holi.out 2>&1',$output1);
                dd($output1);
                
                if(empty($output1)){
                    
                    $output_file = self::$STORAGE_PATH . $output_file;

                    self::checkRunTimeError($output_file);
                    
                    $time = self::getAverageTime($output_file);
                    $memory = self::measureMemory($output_file);

                    self::$RESULTS["memory"] = (int)$memory;
                    self::$RESULTS["time"] = (int)$time;

                    self::evaluateTimeMemory($time,$memory);

                    if(self::$RESULTS["judgment"] == ""){
                        
                        self::evaluateWA($output_file,$problem_id,$language,$id_user);
                        
                    }
                    self::deleteExecutableforC($output_file);
                }
                else{
                    #COMPILATION ERROR!!!
                    self::$RESULTS["judgment"] = self::$VERDICTS[1];
                }
                self::deleteCode($realpath_of_submitted_file);
                
				break;
			case '3':
				# JAVA
                $replace = $nickname_user.'_'.$id_user."_".$problem_id;
                
                self::renameClassForJava($file,$replace);
                $sentence_to_compile = self::$JAVAC. $realpath_of_submitted_file .' -d '.self::$STORAGE_PATH. self::$REDIRECT_OUTPUT;

                exec($sentence_to_compile,$output);
                
                if(empty($output)){

                    $output_file = self::$JAVA.self::$STORAGE_PATH. $replace;

                    self::checkRunTimeError($output_file);

                    $time = self::getAverageTimeJava($output_file);
                    $memory = self::measureMemoryJava($output_file);

                    self::$RESULTS["memory"] = (int)$memory;
                    self::$RESULTS["time"] = (int)$time;

                    self::evaluateTimeMemory($time,$memory);

                    if(self::$RESULTS["judgment"] == ""){
                        
                        self::evaluateWAJava($replace,$output_file,$problem_id,$language,$id_user);
                        
                    }
                    self::deleteExecutableforJava(self::$STORAGE_PATH.$replace);
                }else{
                    #COMPILATION ERROR!!!
                    self::$RESULTS["judgment"] = self::$VERDICTS[1];
                }
                self::deleteCode($realpath_of_submitted_file);
                
				break;
			case '4':
				# PYTHON
                $name = explode('/',$file);
                $output_file = self::$STORAGE_PATH.$name[1];
                $cp = "cp ".$realpath_of_submitted_file . ' '.$output_file;

                exec($cp);

                $sentence_to_execute = self::$PYTHON.$output_file;
                
                self::checkRunTimeError($sentence_to_execute);

                $time = self::getAverageTime($sentence_to_execute);
                $memory = self::measureMemory($sentence_to_execute);
                //dd(self::$MEMORY_LIMIT);
                self::$RESULTS["memory"] = (int)$memory;
                self::$RESULTS["time"] = (int)$time;

                self::evaluateTimeMemory($time,$memory);

                if(self::$RESULTS["judgment"] == ""){
                    
                    self::evaluateWA($sentence_to_execute,$problem_id,$language,$id_user);
                    
                }
                self::deleteCode($realpath_of_submitted_file);
                self::deleteCode($output_file);
				break;	
		}

        // Just evaluate WA and OLE

		return self::$RESULTS;
	}

    /**
     * This function evluate the Wrong Answer or Accepted verdict 
     * and compare the two both out files
     * 
     * @param  string $id_problem 
     * @return  
    */
    static function evaluateWAJava($name_file,$exec_file,$problem_id,$language,$id_user){
        
        $path = self::$STORAGE_PATH;
        $in_files = glob($path . "*.in");
        $index = 1;
        
        foreach($in_files as $in_file){
            $outputname_file = $index.'_'.$problem_id.'_'.$language.'_'.$id_user.'.out';
            $index = $index + 1;
            $cd = 'cd '.self::$STORAGE_PATH . ' && ';
            
            $sentence_to_evaluate_wa = $cd . self::$RTE_SENTENCE. 'java -Djava.compiler=NONE ' .$name_file.' <'.$in_file
                                            .' >' . $outputname_file;
            //dd($sentence_to_evaluate_wa);
            exec($sentence_to_evaluate_wa);
            
            $out_file = explode('.',$in_file);
            $s1 = file_get_contents($out_file[0].'.out');
            $s2 = file_get_contents($path.$outputname_file);
            $ans = strcmp($s1,$s2);
     
            if($ans != 0){//Wrong Answer judgement
                self::$RESULTS["judgment"] = self::$VERDICTS[10];
                unlink($path.$outputname_file);
                break;
            }
            else{//Accepted judgement
                self::$RESULTS["judgment"] = self::$VERDICTS[11];
                unlink($path.$outputname_file);
            }   
        }
        
    }

    /**
     * Delete a file .py .java .c or .cpp
     *
     * @param  string $file name file
     * @return 
    */
    static function deleteCode($file){
        unlink($file);
    }

    /**
     * Delete a .out executable file for c/c++
     *
     * @param  string $file name file
     * @return 
    */
    static function deleteExecutableforC($file){
        $executable = explode('.',$file);
        $name = $executable[0] . ".out";
        unlink($name);
    } 

    /**
     * Delete a .class java file generated
     *
     * @param  string $file name file
     * @return 
    */
    static function deleteExecutableforJava($file){
        $executable = explode('.',$file);
        $name = $executable[0] . ".class";
        unlink($name);
    }

    /**
     * Function to get the average time of execution of the program using time comand mutiple times
     *
     * @param  string $execfile name file
     * @return float $time_average the total time averaged
    */
    static function getAverageTimeJava($exec_file){
        $path = self::$STORAGE_PATH;
        $in_files = glob($path . "*.in");
        $ans = false;
        $real_time_total = 0;
        foreach ($in_files as $in_file){
            $partial_time = 0.0;
            for($i=0;$i<self::$LOOPS_TO_TIME;$i++)
                $partial_time = $partial_time + (float)(self::measureTimeJava($exec_file,$in_file));
            //time evaluated multiple times per case
            $time_average = $partial_time / self::$LOOPS_TO_TIME;
            //Time per case in miliseconds
            $real_time_per_case = $time_average * 1000;
            if($real_time_per_case>self::$TIME_LIMIT){ 
                self::$RESULTS['judgment'] = self::$VERDICTS[6];
                break;
            }
            //total time for every entry of the problem
            $real_time_total = $real_time_total + $real_time_per_case;
        }

        if($real_time_total>self::$TOTAL_TIME_LIMIT)
            self::$RESULTS['judgment'] = self::$VERDICTS[6];

        
        return $real_time_total;
    }


    /**
     * Uses the time command to measure the time of a program
     *
     * @param  string $execution name file
     * @return string $time 
    */
    static function measureTimeJava($exec_file,$in_file){
        $path = self::$STORAGE_PATH;
        $sentence_to_evaluate_time = '('.self::$TIME_SENTENCE.$exec_file.') 2>'.$path.'temp'.' <'.$in_file;
        
        exec($sentence_to_evaluate_time,$evaluated_time_output);

        $temp = fopen($path.'temp','r');
        $usr_time = 0.0;
        $flag = false;
        while (!feof($temp)) {
            $line = fgets($temp);
            if($flag){
                $split1 = explode(' ',$line);
                $split2 = explode('u',$split1[0]);
                $usr_time = (float)$split2[0];
                break;
            }
            if(strpos($line,'Command exited with non-zero status 1') !== false){
                $flag = true;
            }

        }
        fclose($temp);
        unlink($path.'temp');
        return $usr_time; 
    }


    /**
     * Uses the time command to measure the memory of a program
     *
     * @param  string $execution name file
     * @return string $mem 
    */
    static function measureMemoryJava($exec_file){
        $path = self::$STORAGE_PATH;
        $in_files = glob($path . "*.in");
        foreach($in_files as $in_file){
            $sentence_to_evaluate_mem = '('.self::$MEMORY_SENTENCE.$exec_file.') 2>'.$path.'temp'.' <'.$in_file;
            
            exec($sentence_to_evaluate_mem,$evaluated_mem_output);
            break;
        }
        #This returns the memory used in Kb
        $temp = fopen($path.'temp','r');
        $usr_mem = '';
        $flag = false;
        while (!feof($temp)) {
            $line = fgets($temp);
            if($flag){
                $usr_mem = (int)$line;
                break;
            }
            if(strpos($line,'Command exited with non-zero status 1') !== false){
                $flag = true;
            }

        }
        fclose($temp);
        unlink($path.'temp');
        return $usr_mem;
        
    }

    /**
     * Search for the word 'class' to point to the subsequent word that is the name of the file and the class
     *
     * @param  $words array of strings(the line that contains the name of the class) 
     * @return $name_of_class the real name of the class
    */
    static function searchNameOfClass($words){
        $name_of_class;
        $flag = false;
        foreach($words as $s){
            if($flag){
                $name_of_class = $s;
                break;
            }
            if($s == "class")
                $flag = true;
            
        }
        return $name_of_class;
    }

    /**
     * Rename the class using the convention of iduser_idproblem.java this for the correct compilation
     *
     * @param  file $file, $replace $string
     * @return 
    */
    static function renameClassForJava($file,$replace){
        $file_handle = fopen(storage_path('judgments/'.$file), "r+");

        $temp = '';
        $flag = false;
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            if(!$flag && str_contains($line,"class")){
                $words = explode(' ',$line);
                $name_class = self::searchNameOfClass($words);
                $new = str_replace($name_class,$replace,$line);
                $temp.= $new."{\n";
                $flag = true;
            }
            else
                $temp.=$line;
        }
        $file_handle = fopen(storage_path('judgments/'.$file), "w+");
        fwrite($file_handle, $temp);
        fclose($file_handle);
    }

	/**
     * Build a file that contents the code added in the code builder.
     *
     * @param  string $language, string $problem_id, string $code 
     * @return 
     */
    static function buildCodeFile($file,$language,$problem_id,$code,$id_user,$nickname){

        $nameCode = $nickname.'_'.$id_user."_".$problem_id;

        switch ($language) {
            case '1':
                $nameCode .= ".c"; 
                break;
            case '2':
                $nameCode .= ".cpp";
                break;
            case '3':
                $nameCode .= ".java";
                break;
            case '4':
                $nameCode .= ".py";
                break;
            default:
                # code...
                break;
        }

        $path = 'user_'.$id_user.'/problem_'.$problem_id.'/';
        Storage::disk('judgements')->put($path.$nameCode, $code);
        return $path.$nameCode;
    }

    /**
     * Fill the array just in case that one of the parameters dont get any value
     *
     * @param  int $language ID of the language submit
     * @param  int $problem_id ID of the problem submit   
     * @param  int $id_user ID of the id_user submit   
     * @return 
     */
    static function buildResultArray($language, $problem_id, $id_user){
        switch ($language) {
            case '1':
                self::$RESULTS["language"] = "C";
                break;
            case '2':
                self::$RESULTS["language"] = "C++";
                break;
            case '3':
                self::$RESULTS["language"] = "Java";
                break;
            case '4':
                self::$RESULTS["language"] = "Python";
                break;
        }
        
        self::$RESULTS["memory"] = "...";
        self::$RESULTS["time"] = "...";
        self::$RESULTS["judgment"] = "";
        self::$RESULTS["file_size"] = "";
        self::$RESULTS["problem_id"] = $problem_id;
        self::$RESULTS["user_id"] = $id_user;
    }


    /**
     * Evaluate the verdict Size Limit Exceeded
     *
     * @param  int $realpath_of_submitted_file path of the code submitted
     * @return 
     */
    static function evaluateSizeLimitExceeded($realpath_of_submitted_file){
        try {
            self::$RESULTS["file_size"] = filesize( $realpath_of_submitted_file );

            if( self::convertToSizeLimitUnit( self::$RESULTS["file_size"] ) > self::$SIZE_LIMIT){
                self::deleteCode($realpath_of_submitted_file);
                self::$RESULTS["judgment"] = self::$VERDICTS['SLE'];
                return true;
            }
            return false;

        }catch (\Exception $e) {
            self::$RESULTS["judgment"] = self::$VERDICTS['IE'];
            return true;
        }

    }

    /**
     * Convert from bytes to Size limit Unit for now (KB)
     *
     * @param  int $file_size size given in bytes of the code submitted
     * @return 
     */
    static function convertToSizeLimitUnit($file_size){
        /*actually us Size limit is in Kb an the php filesize
         function return the size in bytes for this reason
         we need a conversion from bytes to kilobytes*/
        return ($file_size / 1024);
    }

    /**
     * Evaluate the verdict Restricted function
     *
     * @param  int $realpath_of_submitted_file path of the code submitted
     * @return 
     */
    static function evaluateRestrictedFunction($realpath_of_submitted_file){
        try{
            if( self::searchSystemWords($realpath_of_submitted_file) ){
                self::deleteCode($realpath_of_submitted_file);
                self::$RESULTS["judgment"] = self::$VERDICTS['RF'];
                return true;
            }
            return false;
        }catch(\Exception $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['IE'];
            return true;
        }   
    }

    /**
     * Search in the content of our file if there is a system call or restricted function.
     *
     * @param  srtring $realpath_of_submitted_file 
     * @return array of the words founded
    */
    static function searchSystemWords($realpath_of_submitted_file){
        $contentFile = file_get_contents($realpath_of_submitted_file);

        foreach(self::$RESTRICTED_FUNCTION as $rf)
            if(str_contains($contentFile,$rf))
                return true;
        return false;
    }

    /**
     * Evaluate the verdict Compilation Error
     *
     * @param  string $sentence_to_compile sentence to execute for compilation process
     * @return 
     */
    static function evaluateCompilationError($sentence_to_compile){
        try{
            $process = new Process($sentence_to_compile);
            $process->run();
            // executes after the command finishes
            if (!$process->isSuccessful()) {
                self::$RESULTS["judgment"] = self::$VERDICTS["CE"];
                return true;
            }
            return false;
        }catch(\Exception $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['IE'];
            return true;
        }  
    }

    /**
     * Evaluate the verdict Runtime Error
     *
     * @param  string $exec_file file generated after a compilation
     * @return 
     */
    static function evaluateRuntimeError($exec_file){
        try{

            $path = self::$DATASET_PROBLEM_PATH;
            $in_files = glob($path . "*.in");

            foreach ($in_files as $in_file) {
                $run_time_sentence = $exec_file.' <'.$in_file;
                //The file temp is only for to redirect the output to a file and to know that the program doesnt 
                // generate a output with a Runtime Error
                $process = new Process('exec '.$run_time_sentence);
                $process->setTimeout( (self::$TIME_LIMIT / 1000) );
                $process->run();

                if (!$process->isSuccessful())
                    return false;
            }

        }catch(ProcessTimedOutException $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['TLE'];
            return true;
        }catch(\RuntimeException $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['RTE'];
            return true;
        }
        catch(\Exception $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['IE'];
            return true;
        }  
        
    }

    /**
     * Evaluate the verdicts Time Limit Exceeded, Memory Limit Exceeded, and Runtime Error
     *
     * @param  string $exec_file file generated after a compilation
     * @return 
     */
    static function evaluateTimeLimitExceededMemoryLimitExceededRuntimeError($exec_file){
        try{
            $time_and_memory_average = self::getAverageTimeAndMemory($exec_file);
            self::$RESULTS["time"] = $time_and_memory_average[0];
            self::$RESULTS["memory"] = $time_and_memory_average[1];

            //dd('results time es '.self::$RESULTS["time"]. ' results mem es '.self::$RESULTS["memory"]);
            return false;
        }catch(ProcessTimedOutException $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['TLE'];
            return true;
        }catch(MemoryLimitException $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['MLE'];
            return true;
        }catch(\RuntimeException $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['RTE'];
            return true;
        }/*catch(\Exception $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['IE'];
            return true;
        }*/
        
    }

    /**
     * Function to get the average time and memory usage of execution of the program using time comand mutiple times
     *
     * @param  string $execfile name file
     * @return float $time_average the total time averaged
    */
    static function getAverageTimeAndMemory($exec_file){
        $path = self::$STORAGE_PATH.'/';
        $in_files = glob(self::$DATASET_PROBLEM_PATH . "*.in");
        $total_time = $total_memory = 0;

        foreach ($in_files as $in_file){
            $partial_time = 0.0;
            $partial_memory = 0.0;
            $time_out = (int)(self::$TIME_LIMIT / 1000);
            for($i=0;$i<self::$LOOPS_TO_TIME;$i++){
                $sentence = self::$TIME_AND_MEMORY_SENTENCE.$exec_file.' 2>'.$path.'temp'.' <'.$in_file. ' timeout '.$time_out;

                $process = new Process('exec '.$sentence);
                $process->setTimeout( $time_out );
                $process->run();

                //check RTE or IE
                if(!$process->isSuccessful()){
                    if($process->getExitCode()>128)
                        throw new \RuntimeException();
                    throw new \Exception();
                }
                
                $time_mem = file_get_contents($path.'temp');

                $time =  (float)(explode(' ',$time_mem)[0]);
                $mem =  (float)(explode(' ',$time_mem)[1]);

                $partial_time +=  $time;
                $partial_memory +=  $mem;

                //check TLE
                if( ($time * 1000) > self::$TIME_LIMIT){
                    self::$RESULTS["memory"] = $mem;
                    self::$RESULTS["time"] = $time;
                    throw new ProcessTimedOutException();
                }
                //check MLE
                if( ($mem / 1024) > self::$MEMORY_LIMIT){
                    self::$RESULTS["memory"] = $mem;
                    throw new MemoryLimitException();
                }
            }

            //time  and memory evaluated multiple times per case
            $time_average_per_case = $partial_time / self::$LOOPS_TO_TIME;
            $memory_average_per_case = $partial_memory / self::$LOOPS_TO_TIME;
            
            //total time and total memory for every entry of the problem
            $total_time = $total_time + $time_average_per_case;
            $total_memory = $total_memory + $memory_average_per_case;
        }

        if($total_time>self::$TOTAL_TIME_LIMIT)
            throw new ProcessTimedOutException();
        unlink($path.'temp');
        
        $cases = count($in_files);
        $total_time /= $cases;
        $total_memory /= $cases;
        
        return array($total_time,$total_memory);
    }

    /**
     * This function evluate the Wrong Answer or Accepted verdict 
     * and compare the two both out files
     * 
     * @param  string $id_problem 
     * @return  
    */
    static function evaluateWA($exec_file,$problem_id,$language,$id_user){
       
        try{

            $datset_path = self::$DATASET_PROBLEM_PATH;
            $in_files = glob($datset_path . "*.in");
            $index = 1;
            $temporary_path = self::$STORAGE_PATH. '/';
            foreach($in_files as $in_file){
                $outputname_file = $temporary_path.$index.'_'.$problem_id.'_'.$language.'_'.$id_user.'.out';
                $index++;
                $sentence_to_evaluate_wa = $exec_file.' <'.$in_file
                                                .' >'.$outputname_file;
                //dd($sentence_to_evaluate_wa);
                $process = new Process('exec '.$sentence_to_evaluate_wa);
                $process->setTimeout( (self::$TIME_LIMIT / 1000) );
                $process->run();

                $out_file = explode('.',$in_file);
                $s1 = file_get_contents($out_file[0].'.out');
                $s2 = file_get_contents($outputname_file);
                $ans = strcmp($s1,$s2);
                
                if($ans != 0){//Wrong Answer judgement
                    self::$RESULTS["judgment"] = self::$VERDICTS['WA'];
                    unlink($outputname_file);
                    break;
                }
                else{//Accepted judgement
                    self::$RESULTS["judgment"] = self::$VERDICTS['AC'];
                    unlink($outputname_file);
                }   
            }
            return true;
        }catch(ProcessTimedOutException $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['TLE'];
            return true;
        }catch(\RuntimeException $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['RTE'];
            return true;
        }
        /*catch(\Exception $e){
            self::$RESULTS["judgment"] = self::$VERDICTS['IE'];
            return true;
        }  */
    }

}

?>