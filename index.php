<?php
echo '<pre>';
//$h = fopen("data/convertcsv.csv", "r");
////$data = fgetcsv($h, 1000, ",");
//$the_big_array = [];
//while (($data = fgetcsv($h, 1000, ",")) !== FALSE)
//{
//    // Each individual array is being pushed into the nested array
//    $the_big_array[] = $data;
//}
//fclose($h);
//echo '<pre>';
//var_dump($the_big_array);
//echo '</pre>';
//
//interface dataStrategy {
//    public function getData();
//}
//
//class CsvDataStrategy implements dataStrategy {
//
//    public function getData()
//    {
//
//        var_dump(self::DATA);
//
//    }
//}

//class Data
//{
//    protected $filepath;
//
//    public function __construct(string $filepath)
//    {
//        $this->filepath = $filepath;
//    }
//
//    public function getCsvFile()
//    {
//        $the_big_array = [];
//        if (($h = fopen($this->filepath, 'rb')) !== false) {
//            // Convert each line into the local $data variable
//            while (($data = fgetcsv($h, 1000, ',')) !== false) {
//                var_dump($data);
//                $the_big_array[] = $data;
//                // Read the data from a single line
//            }
//
//            // Close the file
//            fclose($h);
//
//            var_dump($the_big_array);
//        }
//
//    }
//
//    public function getCsv()
//    {
//        $baseCSV = file($this->filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);//Складываем строки из CSV файла в масив
//        foreach ($baseCSV as $itemBaseCSV) {
//            $arrLineCsv = explode(',', $itemBaseCSV);//Формируем масив из отдельной строки по разделителю ;
//
//            var_dump($arrLineCsv);
//        }
////        var_dump($baseCSV);
//    }
//}
//
//$test = new Data('data/convertcsv.csv');
//
//$test->getCsv();


// класса для разбора csv файла
class CsvParser
{
    // указатель на файл
    protected $handle;

    // заголовок csv файла
    protected $header;

    /**
     * Открываем файл на чтение
     *
     * @param $file
     * @param bool $header
     * @return $this
     * @throws \Exception
     */
    public function open($file, $header = true)
    {
        $this->handle = fopen($file, 'r');
        if (!$this->handle) {
            throw new Exception('Невозможно прочитать файл ' . $file);
        }
        if ($header) {
            $this->header = fgetcsv($this->handle);
        }
        return $this;
    }

    /**
     * Разбирает файл, передавая данные из файла
     * в коллбэк функцию
     *
     */
    public function parse(callable $callable)
    {
        if (!$this->handle) {
            throw new Exception('Файл не открыт!');
        }

        $newArray = [];
        $newDataArray = [];

        while (($data = fgetcsv($this->handle)) !== false) {
            if ($this->header) {
                $data = array_combine($this->header, $data);
            }

            // вызываем коллбэк, первый аргумент данные, второй ссылка на объект
//            var_dump($data);
//            $newArray[$data['EMAIL']] = $data['ID'];
//            $newDataArray[] = $data;

            $callable($data, $this);
        }

//        var_dump($newArray);

        //        foreach ($newDataArray as $key => $item) {
        //            if (isset($newArray[$item['EMAIL']])) {
        //                echo $item['ID'] . ' asd ';
        //                $duplicateArray[] = $item['EMAIL'];
        //            }
        //            var_dump($duplicateArray);
        ////            var_dump($key);
        //        }
    }


    public function __destruct()
    {
        $this->close();
    }


    public function close()
    {
        if ($this->handle) {
            fclose($this->handle);
            $this->handle = null;
        }
    }


    public function value($row, $field)
    {
        return $row[$field];
    }
}

$file = 'data/convertcsv.csv';

(new CsvParser())->open($file)->parse(function ($data, CsvParser $csv) {
//    var_dump($data);
    $newArray[$data['EMAIL']] = '';
//    foreach ($data as $value) {
//        $value = $csv->value($data, $fieldName);
//        print $value . PHP_EOL;
//    }
//    var_dump($newArray);
});