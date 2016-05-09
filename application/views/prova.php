
<?php  $this->contentStart("content")?>

<h1> BENVENUTI </h1>
<a href="home">Cliccami</a>
<?php $a=102;
/*$included_files = get_included_files();
echo "test";
foreach ($included_files as $filename) {
    echo "$filename\n";
}*/

?>
<?= $a ?>
 {{ $a }} <br />
 {% foreach($baci as $bo) %}
 bla bla bla
 {% endforeach %} <br />
 {% if(bla bla bla) %}<br />
 succede qualcosa;<br />
 {% endif %}
<
>


<?php $this->contentStop()?>
<?php $this->contentStart("menu") ?>
  <li><a href="#">Action</a></li>
  <li><a href="#">Another action</a></li>
  <li><a href="#">Something else here</a></li>
  <li role="separator" class="divider"></li>
  <li><a href="#">Separated link</a></li>
<?php $this->contentStop() ?>

<?php  $this->extendsLayout('app'); ?>
