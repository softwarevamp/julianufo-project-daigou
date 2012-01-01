<?php

/*
	[SupeSite] (C) 2007-2009 Comsenz Inc.
	$Id: tree.class.php 10898 2008-12-31 02:58:50Z zhaofei $
*/

class Tree {
	var $data = array();
	var $child = array(-1 => array());
	var $layer = array(-1 => -1);
	var $parent = array();
	var $countid = 0;
	var $ret = '';
	function Tree($treearray=array(),$id='id',$parent='parentid') {
		if(is_array($treearray) && !empty($treearray)){
			foreach($treearray as $value){
					$this->setNode($value[$id], $value[$parent], $value);
			}
		}
	}
	
	function setNode($id, $parent, $value) {
		
		$parent = $parent?$parent:0;
	
		$this->data[$id] = $value;
		$this->child[$parent][]  = $id;
		$this->parent[$id] = $parent;
		
		if(!isset($this->layer[$parent])) {
			$this->layer[$id] = 0;
		} else {
			$this->layer[$id] = $this->layer[$parent] + 1;
		}
	}
	
	function get_tree($myid, $str, $sid = 0, $icon=array('│','├','└'),$adds = '')
	{
		$number=1;
		$child = $this->getChild($myid);

		if(is_array($child))
		{
		    $total = count($child);
			foreach($child as $id)
			{
				$j=$k='';
				if($number==$total)
				{
					$j .= $icon[2];
				}
				else
				{
					$j .= $icon[1];
					$k = $adds ? $icon[0] : '';
				}
				$spacer = $adds ? $adds.$j : '';
				$selected = $id==$sid ? 'selected' : '';
				
				$a=$this->getValue($id);
				@extract($a);
				eval("\$nstr = \"$str\";");
				$this->ret .= $nstr;
				$this->get_tree($id, $str, $sid, $icon, $adds.$k.'&nbsp;');
				$number++;
			}
		}
		return $this->ret;
	}	
	
	function getList(&$tree, $root= 0) {
		if (is_array($this->child[$root])) {
			foreach($this->child[$root] as $key => $id) {
				$tree[] = $id;
				if($this->child[$id]) $this->getList($tree, $id);
			}				
		}
	}
	
	function getValue($id) {
		return $this->data[$id];
	}
	
	function reSetLayer($id) {
		if($this->parent[$id]) {
			$this->layer[$this->countid] = $this->layer[$this->countid] + 1;
			$this->reSetLayer($this->parent[$id]);
		}
	}
	
	function getLayer($id, $space = false) {
		//重新计算级数
		$this->layer[$id] = 0;
		$this->countid = $id;
		$this->reSetLayer($id);
		return $space?str_repeat($space, $this->layer[$id]):$this->layer[$id];
	}
	
	function getParent($id) {
		return $this->parent[$id];
	}
	
	function getParents($id) {
		while($this->parent[$id] != -1) {
			$id = $parent[$this->layer[$id]] = $this->parent[$id];
		}
		
		ksort($parent);	//按照键名排序
		reset($parent); //数组指针移回第一个单元
	
		return $parent;
	}
	
	function getChild($id) {
		return $this->child[$id];
	}
	
	function getChilds($id = 0) {
		$child = array();
		$this->getList($child, $id);
		
		return $child;
	}
}

?>