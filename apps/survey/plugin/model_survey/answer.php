<?php

class plugin_answer extends object
{
	private $survey, $answer;
	
	public function __construct($survey)
	{
		$this->survey = $survey;
		$this->answer = loader::model('answer','survey');
	}
	
	public function before_answer()
	{
        $this->_write_file();
        $this->survey->answerid = $this->answer->add($this->survey->contentid, $this->survey->data);
        if (!$this->survey->answerid)
        {
        	$this->survey->error = $this->answer->error();
        }
	}

    private function _write_file()
    {
        if (empty($_FILES) || empty($_FILES['data'])) return;
        $dir = UPLOAD_PATH.date('Y/md/',TIME);
        folder::create($dir);
        foreach ($_FILES['data']['tmp_name'] as $index => $item) {
            if (empty($item)) continue;
            $filePath = $dir . '/' . TIME . rand(1111, 9999);
            move_uploaded_file($item, $filePath);
            $this->survey->data[$index] = str_replace(UPLOAD_PATH, '', $filePath);
        }
    }
}