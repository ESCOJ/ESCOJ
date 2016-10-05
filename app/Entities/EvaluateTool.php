<?php 

namespace ESCOJ\Entities;

class EvaluateTool{

	private static $LIMIT_EXCECUTION_SERVER_SEGS=60;
	private static $RESULTS = array();
	private static $PYTHON = "python ";
	private static $GCC = "clang ";
	private static $GCCPLUSPLUS = "clang++ -std=c++11 ";
	private static $JAVAC = "javac ";
	private static $JAVA = "java -cp ";
	private static $REDIRECT_OUTPUT = " 2>&1 ";
	private static $SYSTEM_WORDS = array('thread','exec','system','fork','pthread_t','pthread_create');
	private static $ERROR_SYSTEM_WORDS = false; 

	static function evaluateCode($file,$language,$problem_id){

		$wordsFounded = self::searchSystemWords($file);

		/*$sentence = "clang ".$temp_path. $name ." -o ".$temp_path.$file_splited[0]." 2>&1 ";
        exec($sentence);

        var_dump($sentence);
        //var_dump($ls . " " .$name . " " . $file_splited[0]);*/

        //var_dump("System words: ".$wordsFounded[0]." File: ".$file." Language: ".$language." Problem ID: ".$problem_id);
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
		
		return $wordsFounded;
	}


	/**
     * Build a file that contents the code added in the code builder.
     *
     * @param  string $language, string $problem_id, string $code 
     * @return 
     */
    static function buildCodeFile($file,$language,$problem_id,$code){

        $nameCode = "";
        switch ($language) {
            case '1':
                $nameCode = $problem_id.".c"; 
                break;
            case '2':
                $nameCode = $problem_id.".cpp";
                break;
            case '3':
                $nameCode = $problem_id.".java";
                break;
            case '4':
                $nameCode = $problem_id.".py";
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