<?php

class Basic  {

    public $currentPage;


    public function pr($var) {
        if ($var != null) {
            echo '<pre>';
            print_r($var);
            echo '</pre>';
        }
    }

    public function imgdir($var) {
        return $this->getConfig('base_url') . 'img/' . $var;
    }

    function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        rrmdir($dir . "/" . $object); else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function errMessage($var) {
        echo '<h2>' . $var . '</h2>';
    }

    public function getPluginfile($file) {
        return BASE_URL . '/' . APP . '/plugins/' . $file;
    }

    function getUrl($path = null) {
        if (!empty($path)) {
            return BASE_URL . '/' . $path;
        } else {
            return BASE_URL;
        }
    }

    function redirect($path = null) {
        if (!empty($path)) {
            $direct = '<script type="text/javascript">';
            $direct .= 'window.location = "' . BASE_URL . '/' . $path . '"';
            $direct .= '</script>';
            echo $direct;
        }
    }

    function __($var = null) {
        $languange = new Language;
        Application::setConfig();
        $id_lang = Application::getConfig('id_lang');
        $base = Application::getConfig('base_url');
        $lang = $this->getISO($id_lang);
        $filename = "application/core/language/" . $lang . ".php";
        if (file_exists($filename)) {
            include $filename;
        }
        $var = strtolower($var);
        if (!empty($_LANGADM[$var])) {
            return $_LANGADM[$var];
        } else {
            return $var;
        }
    }

    function ___($var = null) {
        $languange = new Language;
        $id_lang = $this->getlang();
        $lang = $this->getISO($id_lang);
        $filename = "application/core/language/" . $lang . ".php";
        if (file_exists($filename)) {
            include $filename;
        }
        $var = strtolower($var);
        if (!empty($_LANGADM[$var])) {
            return $_LANGADM[$var];
        } else {
            return $var;
        }
    }

    function myTruncate($string, $limit, $break = ".", $pad = "...") {
        if (strlen($string) <= $limit)
            return $string;
        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }
        return $string;
    }

    function delPlugin($extra) {
        $dirname = APP . '/plugins/' . $extra;

        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                else
                    delete_directory($dirname . '/' . $file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }

    function log_message($level = 'error', $message, $php_error = FALSE) {
        static $_log;

        if (config_item('log_threshold') == 0) {
            return;
        }

        $_log = & load_class('Log');
        $_log->write_log($level, $message, $php_error);
    }

    function display($filename) {
        if (file_exists($filename)) {
            $file = str_replace('phtml', 'php', $filename);
            if (file_exists($file)) {
                include_once $file;
            }
            include_once $filename;
        }
    }

    public function __loginHead() {
        /*  Tampilkan link jika ada yang online */
        return '';
    }

    public function setCurrentUrl($url = null) {
        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace(BASE_ROOT, "", $url);
        $array_tmp_uri = preg_split('[\\/]', $url, -1, PREG_SPLIT_NO_EMPTY);

        if (empty($array_tmp_uri[0])) {
            $this->currentControl = 'page';
            $this->currentPage = 'home';
        } else if ((empty($array_tmp_uri[1])) && (empty($array_tmp_uri[0]))) {
            $this->currentControl = 'page';
            $this->currentPage = 'home';
        } else {
            $this->currentControl = $array_tmp_uri[0];
            $this->currentPage = $array_tmp_uri[1];
        }
    }

    public function getCurrent() {
        $this->setCurrentUrl();
        return $this->currentPage;
    }

    public function activepage() {
        return MODELCLASS;
    }
	
	public function highlight($text, $split_words) {
		//$text = strtolower($text);
		//$split_words = explode(" ",$words);
		foreach($split_words as $word){
			$color = "red";
			//$text = preg_replace("|($word)|Ui","<span style=\"background:".$color."\"><b>$word</b></span>",$text);
			$text = preg_replace("|($word)|Ui","<b>$word</b>",$text);
		}
		return ($text);
	}

    function preg_rp($realname, $date=false) {
        $realname = strtolower($realname);
        $seoname = preg_replace('/\%/', ' percentage', $realname);
        $seoname = preg_replace('/\@/', ' at ', $seoname);
        $seoname = preg_replace('/\&/', ' and ', $seoname);
        $seoname = preg_replace('/\s[\s]+/', '-', $seoname);
        $seoname = preg_replace('/[\s\W]+/', '-', $seoname);
        $seoname = preg_replace('/^[\-]+/', '', $seoname);
        $seoname = preg_replace('/[\-]+$/', '', $seoname);
        $seoname = strtolower($seoname);
        if ($date == true) {
            $seoname = $seoname . '-' . date('M-d-Y');
        }
        return $seoname;
    }

    function updatelang($newlang = null) {
        if ($newlang != null) {
            $_SESSION['lang'] = $newlang;
        }
    }

    function getlang() {
        if (!isset($_SESSION['lang'])) {
            $lang = 'en';
        } else {
            $lang = $_SESSION['lang'];
        }
        return $lang;
    }

    function looplang() {
        $query = $this->selectTable('lang', '*', array('active' => 'Y'));
        while ($data = $this->FetchObject($query)) {
            $datas[] = $data;
        }
        return $datas;
    }

    function countLang() {
        $query = $this->selectTable('lang', '*', array('active' => 'Y'));
        if ($this->NumRows($query) > 1) {
            return true;
        } else {
            return false;
        }
    }

    function showLangSelector() {
        return $this->getElement('html/langSelector');
    }

    function getISO($id_lang) {
        $query = $this->selectTable('lang', '*', array('active' => 'Y', 'id_lang' => $id_lang));
        $data = $this->FetchObject($query);
        return $data->kode_lang;
    }

    function deleteImg($path) {
        if (is_file($path)) {
            return @unlink($path);
        }
    }

    function cekUrl($url) {
        $s = mysql_query("SELECT `url` FROM urls WHERE url = '$url'");
        $d = $this->NumRows($s);
        if($d>=1){
            return false;
        } else {
            return true;
        }
    }

    function confirmation() {
        echo ' <script type="text/javascript">
        <!--
                function show_confirm()
                {
                var answer = confirm("' . $this->__('Are you sure to delete') . '?")
                if (answer){
                       return true;
                }
                else{
                      return false;
                }
                }
        //-->
        
        </script>';
    }
	public function getSkinImage($path){
		return BASE_URL .'/img/'.$path;
	}
	
	public function bulat($bil){
		
		/*$bil1 = 17.127281738247323278;
		$bil2 = 8.28182712;
		printf("Nilai dari bil1 = %1.2f &lt;br&gt;", $bil1);
		printf("Nilai dari bil1 = %1.4f dan bil2 = %1.5f", $bil1, $bil2);*/
		printf("%1.6f", $bil);
	}
	
	public function singlefile($path,$element){
		//$this->pr(pathinfo($library->file_path))
		//$this->pr(pathinfo($library->file_path));
		//echo substr($library->file_path,0,strrpos($library->file_path,'.'));
		//echo substr($library->file_path,0,strrpos($library->file_path,'.'));
		return pathinfo($path,$element);
	}
	
	public function refresh($link=null){
		
		header("refresh:5;url={$link}");
		return "You'll be redirect in about 5 secs. If  not, click <a href='{$link}'>here</a>";
	
	}
	function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan    = $this->getBulan(substr($tgl,5,2));
		$tahun    = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;        
    }    
    function getBulan($bln){
		switch ($bln){
			case 1:
			  return "Januari";
			  break;
			case 2:
			  return "Februari";
			  break;
			case 3:
			  return "Maret";
			  break;
			case 4:
			  return "April";
			  break;
			case 5:
			  return "Mei";
			  break;
			case 6:
			  return "Juni";
			  break;
			case 7:
			  return "Juli";
			  break;
			case 8:
			  return "Agustus";
			  break;
			case 9:
			  return "September";
			  break;
			case 10:
			  return "Oktober";
			  break;
			case 11:
			  return "November";
			  break;
			case 12:
			  return "Desember";
			  break;
		}
	} 
	

}