<!---Examples Of PHP--->
1) <?php
$x=5;
echo $x++;
?>

2) <?php
echo "<br>";
$x=5;
echo ++$x;
?>

3) <?php
echo "<br>";
$a=10;
$b="10";
var_dump($a==$b);
var_dump($a===$b);
?>

4) <?php
echo "<br>";
$x=0;
if($x){
    echo "True";
}else{
echo "False";
}
?>

5) <?php
echo "<br>";
$x="20abc";
echo $x + 10;
?>

6) <?php
echo "<br>";
for ($i=1;$i<=3;$i++){
    echo $i;
}
?>

7) <?php
echo "<br>";
$i=1;
while($i<=3){
    echo $i;
    $i++;
}
?>

8) <?php
echo "<br>";
$colors=["Red","Blue"];
echo count($colors);
?>
