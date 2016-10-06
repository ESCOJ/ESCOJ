<?php 

namespace ESCOJ\Entities;

class EvaluateTool{

	private static $LIMIT_EXCECUTION_SERVER_SEGS=60;
	private static $RESULTS = array();
	private static $PYTHON = "python ";
    private static $TIME_SENTENCE = "/usr/bin/time timeout 60 ";
    private static $MEMORY_SENTENCE = "/usr/bin/time -f '%M ' timeout 60 ";
	private static $GCC = "/usr/bin/clang ";
	private static $GCCPLUSPLUS = "/usr/bin/clang++ -std=c++11 ";
	private static $JAVAC = "javac ";
	private static $JAVA = "java -cp ";
	private static $REDIRECT_OUTPUT = " 2>&1 ";
	private static $SYSTEM_WORDS = array('thread','exec','system','fork','pthread_t','pthread_create');
	private static $ERROR_SYSTEM_WORDS = false; 

	static function evaluateCode($file,$language,$problem_id,$id_user){

		$wordsFounded = self::searchSystemWords($file);
		if(!empty($wordsFounded)){

			return $ERROR_SYSTEM_WORDS;
		}

		switch ($language) {
			case '1':
				# C
				$output_file = $id_user."_".$problem_id.".out";
                $sentence_to_compile = self::$GCC . realpath($file) . " -o " . public_path() . "/temp/" . $output_file .self::$REDIRECT_OUTPUT;

                exec($sentence_to_compile,$output);
                var_dump($output);
                if(empty($output)){
                	
                    self::measureTime($output_file);

                    self::measureMemmory($output_file);
                }
                else{
                    #COMPILATION ERROR!!!
                }
				break;
			case '2':
				# C++
				$output_file = $id_user."_".$problem_id.".out";
                $sentence_to_compile = self::$GCCPLUSPLUS . realpath($file) . " -o " . public_path() . "/temp/" . $output_file .self::$REDIRECT_OUTPUT;

                exec($sentence_to_compile,$output);
                var_dump($output);
                if(empty($output)){
                	
                    self::measureTime($output_file);

                    self::measureMemmory($output_file);
                }
                else{
                    #COMPILATION ERROR!!!
                }
				break;
			case '3':
				# JAVA
                $replace = $id_user."_".$problem_id;
                self::renameClassForJava($file,$replace);
                $sentence_to_compile = self::$JAVAC. realpath($file) . self::$REDIRECT_OUTPUT;

                exec($sentence_to_compile,$output);
                var_dump($output);
                if(empty($output)){
                    #Here we have to analize the output file
                }
				break;
			case '4':
				# PYTHON

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
        $sentence_to_evaluate_time = self::$TIME_SENTENCE."./temp/".$exec_file.self::$REDIRECT_OUTPUT;
        exec($sentence_to_evaluate_time,$evaluated_time_output);
        $all_time = explode(' ',$evaluated_time_output[0]);
        $usr_time = explode('u',$all_time[0]);
        var_dump("Tiempo de ejecución: ".$usr_time[0]." seg");
    }

    /**
     * Uses the time command to measure the memory of a program
     *
     * @param  string $execution name file
     * @return string $mem 
    */
    static function measureMemmory($exec_file){
        $sentence_to_evaluate_mem = self::$MEMORY_SENTENCE."./temp/".$exec_file.self::$REDIRECT_OUTPUT;
        exec($sentence_to_evaluate_mem,$evaluated_mem_output);
        #This returns the memory used in Kb
        $usr_mem = $evaluated_mem_output[0];

        var_dump("Memoria usada en RAM por el programa: ".$usr_mem. " Kb");
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
}


?>