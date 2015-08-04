<?php 
class ProfileMatching{
	public $variable = array();
	public $candidate = array();
	public $values = array();
	public $bobot = array();
	public $core_factor = array();
	public $secondary_factor = array();
	var $ncf = array();
	var $nsf = array();
	public $subtotal = array();
	
	public function ProfileMatching(){
		$this->bobot = array(
			0 => 5,
			-1 => 4,
			1 => 4.5,
			2 => 3.5,
			-2 => 3,
			3 => 2.5,
			-3 => 2,
			4 => 1.5,
			-4 => 1
		);
	}

	public function debug($var=null){
		if(is_null($var)){
			// echo '<pre>';
			// print("<h2>VARIABLE</h2>");
			// print_r($this->variable);
			// print("<h2>CANDIDATE</h2>");
			// print_r($this->candidate);
			// print("<h2>VALUES</h2>");
			// print_r($this->values);
			// print("<h2>BOBOT</h2>");
			// print_r($this->bobot);
			// print("<h2>CORE</h2>");
			// print_r($this->core_factor);
			// print("<h2>SECOND</h2>");
			// print_r($this->secondary_factor);
			print("<h2>NCF</h2>");
			print_r($this->ncf);
			print("<h2>NSF</h2>");
			print_r($this->nsf);
			echo '</pre>';
		} else {
			echo '<pre>';
			print_r($var);
			echo '</pre>';
		}
		
	}

	public function calculate(){
		//Nilai gap
		$gaps = array();
		$bobots = array();
		foreach($this->values as $sId => $nils){
			
			foreach($nils as $key => $nil){
				$gaps[$sId][$key] = ($nil - $this->variable[$key]);
				$bobots[$sId][$key] = $this->bobot[($nil - $this->variable[$key])];
				
			}
		}

		$this->factore_values($bobots,$gaps);
		return ($this->subTotal());
	}

	private function factore_values($bobots,$gaps){
		$cf = array(); $sf=array();$ncf = array();$nsf = array();
		//echo '<pre>'; print_r($bobots); echo '</pre>';
		foreach($bobots as $bId => $_bobot){
			foreach($this->core_factor as $core){
				if(isset($_bobot[$core])){
					$cf[$bId][$core] = $_bobot[$core];
				} else {
					$cf[$bId][$core] = 0;
				}
				
				//echo $_bobot[$core];
				
			}
			
			foreach($this->secondary_factor as $second){
				if(isset($_bobot[$second])){
					$sf[$bId][$second] = $_bobot[$second];
				} else {
					$sf[$bId][$second] = 0;
				}	
				
			}
			
			//echo array_sum($cf[$bId]);
			$sum_ncf = array_sum($cf[$bId]);
			$sum_nsf = array_sum($sf[$bId]);

			$ncf[$bId] = ($sum_ncf / count($this->core_factor));			
			$nsf[$bId] = ($sum_nsf / count($this->secondary_factor));

		}
		//print_r($ncf);
		$this->nsf = $nsf;
		$this->ncf = $ncf;
		
	}

	function subTotal(){
		$persen_core = (60/100);
		$persen_second = (40/100);
		$globals = '';
		if(is_array($this->ncf)){
			foreach($this->ncf as $key => $ncf){
				
				$globals[$key] = (($ncf * $persen_core ) + ($this->nsf[$key] * $persen_second ));
			}
		}
		//if(!empty($globals))
		//arsort($globals);
		$this->subtotal = $globals;
		
		return $this->subtotal;
	}

}
/*
$var1 = array(5,4,4,4,3,3); // Variable kepribadian
$staff = array('T001','T002','T003','T004','T005'); // kantor
$nilai_staff = array(
	array(3,1,2,4,1,2),
	array(4,4,3,1,1,3),
	array(4,2,3,2,2,1),
	array(2,1,3,3,2,1),
	array(3,3,2,1,2,3)
);
$bobot_gap = array(
	0 => 5,
	-1 => 4,
	1 => 4.5,
	2 => 3.5,
	-2 => 3,
	3 => 2.5,
	-3 => 2,
	4 => 1.5,
	-4 => 1
);
$core_factor = array(2,5);
$secondary_factor = array(0,1,3,4);
print_r('<pre>');
print_r($var1);
print_r($staff);
print_r($nilai_staff);
print_r($bobot_gap);
print_r($core_factor);
print_r($secondary_factor);
//Nilai gap
$gaps = array();
$bobots = array();
foreach($nilai_staff as $sId => $nils){
	foreach($nils as $key => $nil){
		$gaps[$sId][$key] = ($nil - $var1[$key]);
		$bobots[$sId][$key] = $bobot_gap[($nil - $var1[$key])];
		
	}
}
print('<h2>GAPS</h2>');
print_r($gaps);
print('<h2>BOBOT</h2>');
print_r($bobots);

foreach($bobots as $bId => $_bobot){
	foreach($core_factor as $core){
		$cf[$bId][$core] = $_bobot[$core];
	}
	
	foreach($secondary_factor as $second){
		$sf[$bId][$second] = $_bobot[$second];
	}
	
	$ncf[] = ((array_sum($cf[$bId])) / 2);
	$nsf[] = ((array_sum($sf[$bId])) / 4);
}

print_r($cf);
print_r($sf);
print('<h2>NCF</h2>');
print_r($ncf);
print('<h2>NSF</h2>');
print_r($nsf);
*/
?>