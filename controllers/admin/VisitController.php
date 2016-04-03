<?php
//访问统计
if (!defined('BASEPATH')) exit('No direct script access allowed');



class VisitController extends Admin {

		public $file;
    protected $visit_config;
    protected $expires_in;
    protected $cache_file;

    public function __construct() {
		parent::__construct();
		$this->visit = $this->model('visit');
		$this->expires_in = 7200;
    $this->file = ICPATH.'config/visit.php';
    if(file_exists($this->file))
    $this->visit_config = unserialize(file_get_contents($this->file));
	}

    public function indexAction() {

    	if ($this->post('submit_del')) {
    		foreach ($_POST as $var => $value) {
    			if (strpos($var, 'del_')!==false) {
    				$id =(int)str_replace('del_','',$var);
    				$this->delAction($id,1);
    			}
    		}
    		$this->adminMsg($this->getCacheCode('visit'). lang('success'), url('admin/visit'),3,1,1);
    	}

    	$page = (int)$this->get('page');
    	$page = (!$page) ? 1 : $page;
    	$pagelist = $this->instance('pagelist');
    	$pagelist->loadconfig();
    	$total = $this->visit->count('visit');
    	$pagesize = isset($this->site['SITE_ADMIN_PAGESIZE']) && $this->site['SITE_ADMIN_PAGESIZE'] ? $this->site['SITE_ADMIN_PAGESIZE'] : 8;
    	$url = url('admin/visit/index',array('page'=>'{page}','visit'=>$visit));
    	$select   = $this->visit->page_limit($page, $pagesize)->order(array('id DESC'));
    	$data     = $select->select();
	    $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();
	    $this->view->assign(array(
	        'list'     => $data,
	        'pagelist' => $pagelist,
	    ));


        $this->view->display('admin/visit_index');
    }

    public function configAction(){

    	if (IS_POST) {
			$data = $this->input->post('data');
			var_dump($this->file);
			$size = file_put_contents($this->file, array2string($data));
			if (!$size) {
                $this->adminMsg('config目录无权限写入');
            }
			$this->adminMsg('保存成功', url('admin/visit/config'), 3, 1, 1);
		}

		$this->template->assign(array(
			'data' => is_file($this->file) ? string2array(file_get_contents($this->file)) : array(),
		));
		$this->template->display('admin/visit_config.html');
    }

    public function editAction() {

		$this->view->display('admin/theme_add');
    }


	/**
	 * 空格填补
	 */
	private function setspace($var) {
		$len = strlen($var) + 2;
		$cha = 25 - $len;
		$str = '';
		for ($i = 0; $i < $cha; $i ++) {
			$str.= ' ';
		}
		return $str;
	}

	//执行sql语句
	private function installsql($sql) {
		$sql = str_replace(array(PHP_EOL, chr(13), chr(10)), 'SQL_IDEACMS_EOL', $sql);
		$ret = array();
		$num = 0;
		$data = explode(';SQL_IDEACMS_EOL', trim($sql));
		foreach($data as $query){
			$queries = explode('SQL_IDEACMS_EOL', trim($query));
			foreach($queries as $query) {
				$ret[$num] .= $query[0] == '#' || $query[0].$query[1] == '--' ? '' : $query;
			} $num++;
		}
		unset($sql);
		foreach($ret as $query) {
			if(trim($query)) {
				if ($this->mysqli) {
					mysqli_query($this->mysqli, $query);
				} else {
					mysql_query($query);
				}
			}
		}
	}

	public function delAction() {

	}







}
