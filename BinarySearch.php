<?php

class BinarySearch
{
	function __construct($filePath){
		$this->filePath = $filePath;
	}
	private $keySep = '\x0A'; //Ключ начала ключа
	private $valueSep = '\t'; //Ключ начала значения
	private $recordLeng = 4000; //Длинна записи
	private $filePath = '';
	public function search($keySearch)
	{
		
		$keyLen = strlen($this->keySep); //Длинна ключа
		$valueLen = strlen($this->valueSep); //Длинна ключа значения
		$fileSize = filesize($this->filePath)/2; //Кол-во символов в файле
		
		$minCof = 0;
		$maxCof = filesize($this->filePath);
		
		$content = file_get_contents($this->filePath, NULL, NULL, 0, $this->recordLeng*2);//Беру данные из файла
		$founds = substr($content, 0, strlen($keySearch));
		
		 
		if(strnatcasecmp($founds, $keySearch) == 0){
			$value = strstr($content, $this->valueSep);
			
			$endValue = strlen($value) - strlen(strstr($value, $this->keySep)); //Длинна лишних данных
			$endValue = $endValue-$valueLen;
			$value = substr($value,$valueLen,$endValue);
			return $value;
		}
		
		while(true){
			$content = file_get_contents($this->filePath, NULL, NULL, (int)$fileSize, $this->recordLeng*2);//Беру данные из файла

			$found = strstr($content, $this->keySep);
			if(empty($found)){
				return 'undef';
			}
			$secFound = strlen($found) - strlen(strstr($found, $this->valueSep)); //Длинна лишних данных
			$secFound = $secFound-$keyLen;
			$founds = substr($found,$keyLen,$secFound); //Ключ

			switch (strnatcasecmp($founds, $keySearch)) {
				case 0:
					$value = strstr($found, $this->valueSep);
					$endValue = strlen($value) - strlen(strstr($value, $this->keySep)); //Длинна лишних данных
					$endValue = $endValue-$valueLen;
					$value = substr($value,$valueLen,$endValue);
					return $value;
					break;
				case 1:
					$maxCof = (int)$fileSize;
					$fileSize = (int)(($maxCof+$minCof)/2);
					break;
				case -1:
					$minCof = (int)$fileSize;
					$fileSize = (int)(($maxCof+$minCof)/2);
					break;
			}
		}
	}

	public function createTestData($sizeMB)
	{
		$key = 1;
		$stringOut = 'KeyElem'.$key++;
		$file = fopen($this->filePath, 'w') or die("не удалось создать файл");
		
		for ($i=0; $i < $sizeMB; $i++) { 

			while(true){
				$stringOut .= $this->keySep.'KeyElem'.$key++;
				$stringOut .= $this->valueSep.bin2hex(random_bytes(10));
				if(memory_get_usage() > 1422000){
					break;
				}
			}

			fwrite($file, $stringOut);
			$stringOut = '';
			
		}
		fclose($file);
	}
	
}
