<?php
function str_replace_limit($find, $replacement, $subject, $limit = 0, &$count = 0){
  if ($limit == 0)
    return str_replace($find, $replacement, $subject, $count);
  $ptn = '/' . preg_quote($find,'/') . '/';
  return preg_replace($ptn, $replacement, $subject, $limit, $count);
}
function randWhiteCards($n,$all){
	$arr=[];
	while(count($arr)<$n){
		$rw=$all["whiteCards"][array_rand($all["whiteCards"])];
		if(!in_array($rw,$arr)) $arr[]=$rw;
	}
	return $arr;
	
}
function computeWCards($ind,$data){
	$tt="<br /><span>";
	foreach($data as $d){
		$tt.='<a href="#" class="w3-btn w3-black card" data-card="'.$ind.'">'.$d.'</a></span><span><br />';
	}
	return $tt."</span><br /><br />";
}
$ar=json_decode(file_get_contents("cah.json"),true);
$randomB=$ar["blackCards"][array_rand($ar["blackCards"])];
?>
<meta name="viewport" content="width=device-width, initial-scale=1, scaling=no">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
<style>
.choice{
	color:red!important;
}
.card{
	word-wrap: break-word;
}
</style>
<script src="jquery.js"></script>
<div class="w3-card-4">
  <div class="w3-container w3-teal">
<h1>Cards Against Humanity</h1>
</div>
<div class="w3-container">
<?php
$text=$randomB["text"];
$cnt=0;
for($i=0;$i<$randomB["pick"];$i++){
    $text=str_replace_limit("_",'<span id="s'.$i.'" data-span="'.$i.'" class="choice">$$$$</span>',$text,1);
	}
	$cnt=substr_count($text,"$$$$");
	$text=str_replace("$$$$","_",$text);

	if($cnt==0){
		$i=0;
		$text.='<br /><span id="s'.$i.'" data-span="'.$i.'" class="choice">_</span>';
	}
	?>
	<div class="w3-container w3-blue">
	<?php
	
		echo "<h4><i>".$text."</i></h4>";

?>
  </div>

<form method="post">
<?php
for($i=0;$i<$randomB["pick"];$i++){
	?>
	<input type="text" class="cardInput w3-input" name="pick[<?php echo $i; ?>]" placeholder="Carta #<?php echo ($i+1); ?>" id="c<?php echo $i; ?>" data-cardno="<?php echo $i; ?>"><br />
	<?php
	echo computeWcards($i,randWhiteCards(5,$ar));
}
?>
<input type="submit" class="w3-button w3-teal" value="Ok">
</form>
</div>
</div>
<script>
function setB(a){
	var text=a.val();
	if(text.length==0) text="_";
	$("[data-span="+a.attr("data-cardno")+"]").text(text);
}
$(".cardInput").on("input",function(){setB($(this));});
$(".card").on("click",function (){
	var text=$(this).text();
	var cardI=$("[data-cardno="+$(this).attr("data-card")+"]");
	cardI.val(text);
 setB(cardI);
});
</script>