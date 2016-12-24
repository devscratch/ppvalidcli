<?php
error_reporting(0);
function delete_cookie()
{
  $files = 'cookie.txt';
  fopen($files, 'w');
  fwrite($files, '');
  fclose($files);
}
function check_valid($email)
{
  $source = file_get_contents('http://localhost/api.php?email=' . $email);
  $check = json_decode($source, true);
  if($check['status'] == 'Not Valid')
  {
    //return var_dump($check['status']);
    return false;
  }
  else
  {
    return $check;
  }
}
switch ($argv[1]) {
  default:
    echo "><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>< \r\n";
    echo ">  USAGE :                                                           < \r\n";
    echo ">    CHECK VALID : php -f " . $argv[0] . " check mailist.txt result.txt          < \r\n";
    echo ">    SHOW CREDIT : php -f " . $argv[0] . " credits                         < \r\n";
    echo "><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>< \r\n";
    break;
  case "check" :
    if(file_exists($argv[2]) && pathinfo($argv[2], PATHINFO_EXTENSION) == "txt")
    {
      if(file_get_contents($argv[2]) !== "")
      {
        if(file_exists($argv[3]) && pathinfo($argv[3], PATHINFO_EXTENSION) == "txt" )
        {
          $mailist = explode("\r\n", file_get_contents($argv[2]));
          $count   = count($mailist);
          $init    = 1;
          $live    = 0;
          $die     = 0;
          $limited = 0;
          foreach ($mailist as $key => $mail)
          {
            echo "checking [" . $init . "/" . $count . "] | " . $mail . " => ";
            $check = check_valid($mail);
            if(!$check)
            {
              echo "[DIE]\r\n";
              $die++;
            }
            elseif($check['status'] == 'Valid')
            {
              echo "[LIVE] | [" . $check['details']['country'] . "] | [" . $check['details']['date'] ."] \r\n";
              $files  = fopen($argv[3], "a") or die("Gak bisa di save bro! kasih hak akses dolo..");
              fwrite($files, "[LIVE] => " . $mail . " | COUNTRY : " . $check['details']['country'] . "| ~rizalio \r\n");
              $live++;
            }
            else
            {
              echo "[LIMITED] | [" . $check['details']['country'] . "] | [" . $check['details']['date'] ."] \r\n";
              $files  = fopen($argv[4], "a") or die("Gak bisa di save bro! kasih hak akses dolo..");
              fwrite($files, "[LIMITED] => " . $mail . " | COUNTRY : " . $check['details']['country'] . "| ~rizalio \r\n");
              $live++;
            }
            //var_dump($check);
            $init ++;
          }
          echo "><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>< \r\n";
          echo ">                           REPORT RESULT                            < \r\n";
          echo ">                LIVE => " . $live . " | [DIE] => " . $die . " | TOTAL => " . $count . "                < \r\n";
          echo "><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>< \r\n";
        }
        else
        {
          echo "File " . $argv[3] . " gak ada bro di directory! masukin command : php -f " . $argv[0] . " create " . $argv[3] . " buat bikin filenya :), atau mungkin bukan file .TXT \r\n";
        }
      }
      else
      {
        echo "File " . $argv[2] . " gak ada isinye bro, lu mau ngecek apaan! \r\n";
      }
    }
    else
    {
      echo "File " . $argv[2] . " gak ada bro di directory!, pastiin file .TXT ya! \r\n";
    }
  break;
  case "reset" :
    delete_cookie();
  break;
  case "create" :
    if(isset($argv[2]))
    {
      if(file_exists($argv[2]))
      {
        echo "File " . $argv[2] . " udah ada bro, gak perlu generate lagi! \r\n";
      }
      else
      {
        fopen($argv[2], "x");
        echo "File " . $argv[2] . " sukses dibuat! \r\n";
      }
    }
    else
    {
      echo "Kasih nama filenya bro! \"php -f " . $argv[0] . " create namafile.txt\"\r\n";
    }
  break;
}
function  random_uagent()
{
	$giolac = rand(0,13);
		switch ($giolac) {
			case 0:		return "Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36";     break;
			case 1:		return "Mozilla/5.0 (Linux; U; Android 4.1.2; en-gb; GT-I9105 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30";     break;
			case 2:		return "Mozilla/5.0 (Linux; Android 4.2.2; QUANTUM 4 Build/GOCLEVER) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.138 Mobile Safari/537.36";     break;
			case 3:		return "Mozilla/5.0 (Linux; U; Android 4.1.2; en-nz; GT-P3100 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Safari/534.30";     break;
			case 4:		return "Mozilla/5.0 (iPad; CPU OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/34.0.1847.18 Mobile/11B554a Safari/9537.53";     break;
			case 5:		return "Mozilla/5.0 (iPad; CPU OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B554a Safari/9537.53";     break;
			case 6:		return "Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D167 Safari/9537.53";     break;
			case 7:		return "Mozilla/5.0 (iPad; CPU OS 7_1_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D201 Safari/9537.53";     break;
			case 8:		return "Mozilla/5.0 (iPad; CPU OS 7_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/33.0.1750.21 Mobile/11D167 Safari/9537.53";     break;
			case 9:		return "Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_1 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D201 Safari/9537.53";     break;
			case 10:	return "Mozilla/5.0 (iPhone; CPU iPhone OS 6_1_2 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B146 Safari/8536.25";     break;
			case 11:	return "Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16";     break;
			case 12:	return "Mozilla/5.0 (Linux; U; Android 2.2; en-us; Sprint APA9292KT Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1";     break;
			case 13:	return "Mozilla/5.0 (iPad; U; CPU OS 4_2_1 like Mac OS X; ja-jp) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148 Safari/6533.18.5";     break;
		}
	return $giolac;
}
