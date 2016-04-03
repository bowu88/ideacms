<?php
//访问统计
if (!defined('BASEPATH')) exit('No direct script access allowed');



class VisitController extends Common {

		public $file;
    protected $visit_config;
    protected $expires_in;
    protected $cache_file;

    public function __construct() {
		parent::__construct();
    $this->visit = $this->model('visit');
		//$this->expires_in = 7200;
    $this->file = ICPATH.'config/visit.php';
    //$this->cache_file = 'wx_user';
    if(file_exists($this->file))
    $this->visit_config = unserialize(file_get_contents($this->file));
    //$this->createTable();
	}

    public function indexAction() {

      $browser = $this->post('browser');
      $referrer = $this->post('referrer');
      $get = $this->post('get');
      $lang = $this->post('lang');
      $os = $this->post('os');
      $ua = $this->post('ua');

			//获取ip地址
			if (getenv("HTTP_CLIENT_IP")){
				$ip = getenv("HTTP_CLIENT_IP");
			}elseif(getenv("HTTP_X_FORWARDED_FOR")){
				$ip = getenv("HTTP_X_FORWARDED_FOR");
			}elseif(getenv("REMOTE_ADDR")){
				$ip = getenv("REMOTE_ADDR");
			} else {
				$ip = 0;
			}


			//访问来源
			$referrer_array = array("baidu","谷歌","Bing","360搜索","搜狗","站内","直接访问","外链");
      switch ($referrer) {
        case '0':
          $referrer = '百度';
          break;
        case '1':
          $referrer = '谷歌';
          break;
        case '2':
          $referrer = 'Bing';
          break;
        case '3':
          $referrer = '360搜索';
          break;
        case '4':
          $referrer = '搜狗';
          break;
        case '5':
          $referrer = '站内';
          break;
        case '6':
          $referrer = '直接访问';
          break;
        case '7':
          $referrer = '外链';
          break;
        default:
          $referrer = '未知';
          break;
      }

			$ch = curl_init();
	    $url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip='.$ip;
	    $header = array(
	        'apikey: '. $this->visit_config['apikey'],
	    );
	    // 添加apikey到header
	    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    // 执行HTTP请求
	    curl_setopt($ch , CURLOPT_URL , $url);
	    $res = curl_exec($ch);
	    $datajson = json_decode($res,true);
	    $datas = $datajson['retData'];
      $source[] = json_decode($datas);
      $data['ip'] = $ip;
      $data['country'] = $source['country'];
      $data['province'] = $source['province'];
      $data['city'] = $source['city'];
      $data['district'] = $source['district'];
      $data['carrier'] = $source['carrier'];
      $data['browser'] = $browser;
      $data['referrer'] = $referrer;
      $data['get'] = $get;
      $data['lang'] = $lang;
      $data['os'] = $os;
      $data['ua'] = $ua;
      $data['year'] = date('Y',time());
      $data['month'] = date('m',time());
      $data['day'] = date('d',time());
      $data['time'] = time();

      $this->visit->insert($data);
    }




}
