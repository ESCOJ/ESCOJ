<?php 

namespace ESCOJ\EscojLB;

class EvaluateTool{

    private static $STORAGE_PATH = '';
	private static $LIMIT_EXCECUTION_SERVER_SEGS=60;
	private static $RESULTS = array();
	private static $PYTHON = "python ";
    private static $RTE_SENTENCE = "timeout 60 ";
    private static $OPTIMIZED_COMPILATION = "";
    private static $TIME_SENTENCE = "time timeout 60 ";
    private static $MEMORY_SENTENCE = "/usr/bin/time -f '%M ' timeout 60 ";
	private static $GCC = "/usr/bin/clang ";
	private static $GCCPLUSPLUS = "/usr/bin/clang++ -std=c++11 ";
	private static $JAVAC = "javac ";
	private static $JAVA = "java -Djava.compiler=NONE -cp ";
	private static $REDIRECT_OUTPUT = " 2>&1 ";
	private static $SYSTEM_WORDS = array('thread','exec','system','fork','pthread_t','pthread_create','fopen','for(;;)');
    private static $LOOPS_TO_TIME =  5;
    private static $SIZE_LIMIT = 0;
    private static $TIME_LIMIT = 0;
    private static $MEMORY_LIMIT = 0;
    private static $TOTAL_TIME_LIMIT = 0;
	private static $ERROR_SYSTEM_WORDS = array(
        "Invalid Function",
        "Compilation Error",
        "Size Limit Exceeded",
        "Unqualified",
        "Internal Error",
        "Runtime Error",
        "Time Limit Exceeded",
        "Memory Limit Exceeded",
        "Output Limit Exceeded",
        "Presentation Error",
        "Wrong Answer",
        "Accepted");

    /*
        language
        memory
        time
        judgment
        file_size
        problem_id
        user_id

    */
	static function evaluateCode($file,$language,$problem_id,$id_user,$limits,$nickname_user){
        self::$STORAGE_PATH = storage_path() . "/datasets/problem_".$problem_id.'/';
          
        self::$MEMORY_LIMIT = (isset($limits['ml']) == true ?  (int)$limits['ml']:0);
        self::$SIZE_LIMIT = (isset($limits['sl']) == true ? (int)$limits['sl']:0);
        self::$TIME_LIMIT = (isset($limits['tlpc']) == true ? (int)$limits['tlpc']:0);
        self::$TOTAL_TIME_LIMIT = (isset($limits['ttl']) == true ? (int)$limits['ttl']:0);
        
        self::buildResultArray($language);
        self::$RESULTS["problem_id"] = $problem_id;
        self::$RESULTS["user_id"] = $id_user;
        $size_file = filesize(public_path() . '/' . $file);
        self::$RESULTS["file_size"] = (string)$size_file;
        
		$wordsFounded = self::searchSystemWords($file);
		if(!empty($wordsFounded)){
            self::deleteCode(public_path() . '/' . $file);

            self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[6];
			return self::$RESULTS;
		}
        
        if($size_file > self::$SIZE_LIMIT){
            self::deleteCode(public_path() . '/' . $file);

            self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[2];
            return self::$RESULTS;
        }

		switch ($language) {
			case '1':
				# C
				$output_file = $nickname_user.'_'.$id_user."_".$problem_id.".out";

                $sentence_to_compile = self::$GCC . realpath($file) . " -o " . self::$STORAGE_PATH . $output_file .self::$OPTIMIZED_COMPILATION.self::$REDIRECT_OUTPUT;

                exec($sentence_to_compile,$output1);
                
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
                    self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[1];
                }
                self::deleteCode(public_path() . '/' . $file);
                
				break;
			case '2':
				# C++
				$output_file = $nickname_user.'_'.$id_user."_".$problem_id.".out";

                $sentence_to_compile = self::$GCCPLUSPLUS . realpath($file) . " -o " . self::$STORAGE_PATH . $output_file .self::$OPTIMIZED_COMPILATION.self::$REDIRECT_OUTPUT;

                exec($sentence_to_compile,$output1);
                
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
                    self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[1];
                }
                self::deleteCode(public_path() . '/' . $file);
                
				break;
			case '3':
				# JAVA
                $replace = $nickname_user.'_'.$id_user."_".$problem_id;
                
                self::renameClassForJava($file,$replace);
                $sentence_to_compile = self::$JAVAC. realpath($file) .' -d '.self::$STORAGE_PATH. self::$REDIRECT_OUTPUT;

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
                    self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[1];
                }
                self::deleteCode(public_path() . '/' . $file);
                
				break;
			case '4':
				# PYTHON
                $name = explode('/',$file);
                $output_file = self::$STORAGE_PATH.$name[1];
                $cp = "cp ".realpath($file) . ' '.$output_file;
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
                self::deleteCode(public_path() . '/' . $file);
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
                self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[10];
                unlink($path.$outputname_file);
                break;
            }
            else{//Accepted judgement
                self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[11];
                unlink($path.$outputname_file);
            }   
        }
        
    }

    /**
     * This function evluate the Wrong Answer or Accepted verdict 
     * and compare the two both out files
     * 
     * @param  string $id_problem 
     * @return  
    */
    static function evaluateWA($exec_file,$problem_id,$language,$id_user){
        
        $path = self::$STORAGE_PATH;
        $in_files = glob($path . "*.in");
        $index = 1;
        
        foreach($in_files as $in_file){
            $outputname_file = $index.'_'.$problem_id.'_'.$language.'_'.$id_user.'.out';
            $index = $index + 1;
            $sentence_to_evaluate_wa = self::$RTE_SENTENCE.$exec_file.' <'.$in_file
                                            .' >'.self::$STORAGE_PATH. $outputname_file;
            
            exec($sentence_to_evaluate_wa);

            $out_file = explode('.',$in_file);
            $s1 = file_get_contents($out_file[0].'.out');
            $s2 = file_get_contents($path.$outputname_file);
            $ans = strcmp($s1,$s2);
     
            if($ans != 0){//Wrong Answer judgement
                self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[10];
                unlink($path.$outputname_file);
                break;
            }
            else{//Accepted judgement
                self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[11];
                unlink($path.$outputname_file);
            }   
        }
        
    }

    /**
     * Function to return to the view the verdict from the evaluatetool 
     *
     * @param  float $time $memory
     * @return the view 
    */
    static function evaluateTimeMemory($time,$memory){
        if($memory > self::$MEMORY_LIMIT){
            self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[7];
        }
        if($time > self::$TIME_LIMIT){
            self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[6];
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
    static function getAverageTime($exec_file){
        $path = self::$STORAGE_PATH;
        $in_files = glob($path . "*.in");
        $ans = false;
        $real_time_total = 0;
        foreach ($in_files as $in_file){
            $partial_time = 0.0;
            for($i=0;$i<self::$LOOPS_TO_TIME;$i++)
                $partial_time = $partial_time + (float)(self::measureTime($exec_file,$in_file));
            //time evaluated multiple times per case
            $time_average = $partial_time / self::$LOOPS_TO_TIME;
            //Time per case in miliseconds
            $real_time_per_case = $time_average * 1000;

            if($real_time_per_case>self::$TIME_LIMIT){ 
                self::$RESULTS['judgment'] = self::$ERROR_SYSTEM_WORDS[6];
                break;
            }
            //total time for every entry of the problem
            $real_time_total = $real_time_total + $real_time_per_case;
        }
        
        return $real_time_total;
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
                self::$RESULTS['judgment'] = self::$ERROR_SYSTEM_WORDS[6];
                break;
            }
            //total time for every entry of the problem
            $real_time_total = $real_time_total + $real_time_per_case;
        }
        
        return $real_time_total;
    }

    /**
     * Function that execute once the execute sentence and send the response to
     * the runTimeErrorSorter to know what kind of RTE is.
     *
     * @param  string $execfile name file
     * @return 
    */
    static function checkRunTimeError($exec_file){
        $path = self::$STORAGE_PATH;
        $in_files = glob($path . "*.in");
        foreach ($in_files as $in_file) {
            $sentence_to_evaluate_time = self::$RTE_SENTENCE.$exec_file.' <'.$in_file.' >'.$path.'temp '.self::$REDIRECT_OUTPUT;
            //The file temp is only for to redirect the output to a file and to know that the program doesnt 
            // generate a output with a Runtime Error
            exec($sentence_to_evaluate_time,$evaluated_time_output);
            if(!empty($evaluated_time_output)){
                self::runTimeErrorSorter($evaluated_time_output);
            }
            unlink($path.'temp');
        }
        
    }

    /**
     * This function sorts the RTE result getting the response of the terminal just running once the program
     *
     * @param  array $error the error generated
     * @return string $ERROR_SYSTEM_WORDS[i] the string RunTime Error
    */
    static function runTimeErrorSorter($error){
        $rte = $error[0];
        switch ($rte) {
            case 'Segmentation fault':
                //var_dump('Segmentation fault');
                self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[5];
                break;
            case 'Floating point exception':
                //var_dump('Floating point exception');
                self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[5];
                break;
            default:
                self::$RESULTS["judgment"] = self::$ERROR_SYSTEM_WORDS[5];
                break;
        }
    }

    /**
     * Uses the time command to measure the time of a program
     *
     * @param  string $execution name file
     * @return string $time 
    */
    static function measureTime($exec_file,$in_file){
        $path = self::$STORAGE_PATH;
        $sentence_to_evaluate_time = '('.self::$TIME_SENTENCE.$exec_file.') 2>'.$path.'temp'.' <'.$in_file;
        
        exec($sentence_to_evaluate_time,$evaluated_time_output);

        $tle = file_get_contents($path.'temp');
        //dd($tle);
        if(strpos('Command exited with non-zero status 124',$tle) !== true){
            $partial1 = explode(' ',$tle);
            $partial2 = explode('u',$partial1[0]);
            $usr_time = (float)$partial2[0];
        }else{
            $partial1 = explode('124',$tle);
            $partial2 = explode(' ',$partial1[1]);
            $partial3 = explode('s',$partial2[1]);
            $usr_time = (float)$partial3[0];
        }

        //dd($usr_time);
        unlink($path.'temp');
        return $usr_time; 
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
    static function measureMemory($exec_file){
        $path = self::$STORAGE_PATH;
        $in_files = glob($path . "*.in");
        foreach($in_files as $in_file){
            $sentence_to_evaluate_mem = '('.self::$MEMORY_SENTENCE.$exec_file.') 2>'.$path.'temp'.' <'.$in_file;

            exec($sentence_to_evaluate_mem,$evaluated_mem_output);
            break;
        }
        #This returns the memory used in Kb
        $usr_mem = (int)file_get_contents($path.'temp');
        unlink($path.'temp');
        return $usr_mem;
        
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
	 * Search in the content of our file if there is a system call.
     *
     * @param  file $file
     * @return array of the words founded
	*/
	static function searchSystemWords($file){
		$wordsFounded = array();
		$file_handle = fopen($file, "r");
		$file_path = (string)$file;
		$contentFile = file_get_contents($file_path);

        foreach(self::$SYSTEM_WORDS as $sw)
        {
            if(str_contains($contentFile,$sw))
            {
                array_push($wordsFounded,$sw);
                $ERROR_SYSTEM_WORDS = true;
            }
        }
		fclose($file_handle);
		return $wordsFounded;
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
        $file_handle = fopen($file, "r+");
        $file_path = (string)$file;
        //var_dump($file);
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
        $file_handle = fopen($file, "w+");
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


            $nameCode = $nickname.'_'.$id_user."_";

        switch ($language) {
            case '1':
                $nameCode .= $problem_id.".c"; 
                break;
            case '2':
                $nameCode .= $problem_id.".cpp";
                break;
            case '3':
                $nameCode .= $problem_id.".java";
                break;
            case '4':
                $nameCode .= $problem_id.".py";
                break;
            default:
                # code...
                break;
        }
        
        $file_code = fopen("temp/".$nameCode,"w");
        /*$file_temp = $file->storeAs("temp",$nameCode,"judgements");
        file_put_contents($file_temp, $code);*/
        fwrite($file_code,$code);
        fclose($file_code);
        return $nameCode;
    }

    /**
     * Fill the array just in case that one of the parameters dont get any value
     *
     * @param  string $language 
     * @return 
     */
    static function buildResultArray($language){
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
        self::$RESULTS["problem_id"] = "";
        self::$RESULTS["user_id"] = "";
    }
}


?>