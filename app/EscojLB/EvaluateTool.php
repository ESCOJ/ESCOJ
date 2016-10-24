<?php 

namespace ESCOJ\EscojLB;

class EvaluateTool{

	private static $LIMIT_EXCECUTION_SERVER_SEGS=60;
	private static $RESULTS = array();
	private static $PYTHON = "python ";
    private static $RTE_SENTENCE = "timeout 60 ";
    private static $OPTIMIZED_COMPILATION = "";
    private static $TIME_SENTENCE = "/usr/bin/time timeout 60 ";
    private static $MEMORY_SENTENCE = "/usr/bin/time -f '%M ' timeout 60 ";
	private static $GCC = "/usr/bin/clang ";
	private static $GCCPLUSPLUS = "/usr/bin/clang++ -std=c++11 ";
	private static $JAVAC = "javac ";
	private static $JAVA = "java -Djava.compiler=NONE -cp ";
	private static $REDIRECT_OUTPUT = " 2>&1 ";
	private static $SYSTEM_WORDS = array('thread','exec','system','fork','pthread_t','pthread_create','fopen');
    private static $LOOPS_TO_TIME =  5;
    private static $SIZE_LIMIT = 0;
    private static $TIME_LIMIT = 20000;
    private static $MEMORY_LIMIT = 20000;
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
	static function evaluateCode($file,$language,$problem_id,$id_user){
        
        self::buildResultArray($language);
        self::$RESULTS["problem_id"] = $problem_id;
        self::$RESULTS["user_id"] = $id_user;
        $size_file = filesize(public_path() . '/' . $file);
        self::$RESULTS["file_size"] = (string)$size_file;
        //var_dump($size_file);

		$wordsFounded = self::searchSystemWords($file);
		if(!empty($wordsFounded)){
            self::deleteCode(public_path() . '/' . $file);

            self::$RESULTS["judgment"] = $ERROR_SYSTEM_WORDS[0];
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
				$output_file = $id_user."_".$problem_id.".out";
                $sentence_to_compile = self::$GCC . realpath($file) . " -o " . public_path() . "/temp/" . $output_file .self::$OPTIMIZED_COMPILATION.self::$REDIRECT_OUTPUT;

                exec($sentence_to_compile,$output);
                
                if(empty($output)){
                	
                    $output_file = public_path() . '/temp/' . $output_file;

                    self::checkRunTimeError($output_file);
                    $time = self::getAverageTime($output_file);
                    $memory = self::measureMemory($output_file);

                    self::$RESULTS["memory"] = (string)$memory;
                    self::$RESULTS["time"] = (string)$time;

                    self::evaluateTimeMemory($time,$memory);
                }
                else{
                    #COMPILATION ERROR!!!
                    self::$RESULTS["judgment"] = $ERROR_SYSTEM_WORDS[1];
                }
                self::deleteCode(public_path() . '/' . $file);
                self::deleteExecutableforC(public_path(). '/' . $file);
				break;
			case '2':
				# C++
				$output_file = $id_user."_".$problem_id.".out";
                $sentence_to_compile = self::$GCCPLUSPLUS . realpath($file) . " -o " . public_path() . "/temp/" . $output_file .self::$OPTIMIZED_COMPILATION.self::$REDIRECT_OUTPUT;

                exec($sentence_to_compile,$output);
                
                if(empty($output)){
                	
                    $output_file = public_path() . '/temp/' . $output_file;

                    self::checkRunTimeError($output_file);
                    $time = self::getAverageTime($output_file);
                    $memory = self::measureMemmory($output_file);

                    self::evaluateTimeMemory($time,$memory);
                }
                else{
                    #COMPILATION ERROR!!!
                    self::$RESULTS["judgment"] = $ERROR_SYSTEM_WORDS[1];
                }
                self::deleteCode(public_path() . '/' . $file);
                self::deleteExecutableforC(public_path() . '/' . $file);
				break;
			case '3':
				# JAVA
                $replace = $id_user."_".$problem_id;
                self::renameClassForJava($file,$replace);
                $sentence_to_compile = self::$JAVAC. realpath($file) . self::$REDIRECT_OUTPUT;

                exec($sentence_to_compile,$output);
                
                
                if(empty($output)){

                    $output_file = self::$JAVA.public_path() . '/temp ' . $replace;

                    $time = self::getAverageTime($output_file);
                    $memory = self::measureMemmory($output_file);

                    self::evaluateTimeMemory($time,$memory);

                }else{
                    #COMPILATION ERROR!!!
                    self::$RESULTS["judgment"] = $ERROR_SYSTEM_WORDS[1];
                }
                self::deleteCode(public_path() . '/' . $file);
                self::deleteExecutableforJava(public_path() . '/' . $file);
				break;
			case '4':
				# PYTHON
                $sentence_to_execute = self::$PYTHON.realpath($file);
                
                $time = self::getAverageTime($sentence_to_execute);
                $memory = self::measureMemmory($sentence_to_execute);

                self::evaluateTimeMemory($time,$memory);

                self::deleteCode(public_path() . '/' . $file);
				break;	
		}

        // Just evaluate WA and OLE

		return self::$RESULTS;
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
        $partial_time = 0.0;
        for($i=0;$i<self::$LOOPS_TO_TIME;$i++)
            $partial_time = $partial_time + (float)(self::measureTime($exec_file));
        
        $time_average = $partial_time / self::$LOOPS_TO_TIME;
        //var_dump("Tiempo de ejecución: ".$time_average." seg");
        return $time_average;
    }

    /**
     * Function that execute once the execute sentence and send the response to
     * the runTimeErrorSorter to know what kind of RTE is.
     *
     * @param  string $execfile name file
     * @return 
    */
    static function checkRunTimeError($exec_file){
        $sentence_to_evaluate_time = self::$RTE_SENTENCE.$exec_file.self::$REDIRECT_OUTPUT;
        exec($sentence_to_evaluate_time,$evaluated_time_output);
        
        if(!empty($evaluated_time_output)){
            self::runTimeErrorSorter($evaluated_time_output);
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
                self::$RESULTS["judgment"] = $ERROR_SYSTEM_WORDS[5];
                break;
            case 'Floating point exception':
                //var_dump('Floating point exception');
                self::$RESULTS["judgment"] = $ERROR_SYSTEM_WORDS[5];
                break;
            default:
                self::$RESULTS["judgment"] = $ERROR_SYSTEM_WORDS[5];
                break;
        }
    }

    /**
     * Uses the time command to measure the time of a program
     *
     * @param  string $execution name file
     * @return string $time 
    */
    static function measureTime($exec_file){
        
        $sentence_to_evaluate_time = self::$TIME_SENTENCE.$exec_file.self::$REDIRECT_OUTPUT;
        exec($sentence_to_evaluate_time,$evaluated_time_output);

        $all_time = explode(' ',$evaluated_time_output[0]);
        $usr_time = explode('u',$all_time[0]);
        
        return $usr_time[0]; 
    }

    /**
     * Uses the time command to measure the memory of a program
     *
     * @param  string $execution name file
     * @return string $mem 
    */
    static function measureMemory($exec_file){
        $sentence_to_evaluate_mem = self::$MEMORY_SENTENCE.$exec_file.self::$REDIRECT_OUTPUT;
        exec($sentence_to_evaluate_mem,$evaluated_mem_output);
        #This returns the memory used in Kb
        $usr_mem = $evaluated_mem_output[0];
        return $usr_mem;
        //var_dump("Memoria usada en RAM por el programa: ".$usr_mem. " Kb");
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
    static function buildCodeFile($file,$language,$problem_id,$code,$id_user){

        $nameCode = $id_user."_";
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