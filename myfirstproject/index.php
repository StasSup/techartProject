<?require_once('.\local\templates\header.php');?>
<?
$host = 'localhost';
$database = 'mydb';
$user = 'mysql';
$password = 'mysql';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));

if(isset($_GET['new']) && !empty($_GET['new'])){

	$query ="SELECT * FROM news WHERE id =". $_GET['new'];
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	$obj = $result->fetch_object()
?>
	<div class="mainWrapper">
		<div class="headerNewWrapper">
			<p>
				<?=$obj->title?>
			</p>
		</div>
		<div class="contentNew">
			<p>
				<?=$obj->content?>
			</p>
		</div>
		<div class="allNewsBtn" onClick = (changePage(1,'page'))>Все новости>>></div>
	</div>
<? 
} else {

	$pageSize = 5;
	if(isset($_GET['page']) && !empty($_GET['page'])){
			$startNew = $_GET['page'] * $pageSize - $pageSize;
			$query = "SELECT * FROM news ORDER BY idate DESC LIMIT $startNew, $pageSize";
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	} else {
			$startNew = 0;
			$query = "SELECT * FROM news ORDER BY idate DESC LIMIT $startNew, $pageSize";
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	}
?>

<div class="mainWrapper">
	<div class="headerWrapper">
	    <p>
	        	Новости
	    </p>
	</div>
	<div class="newsBodyWrapper">
	<?
		while($obj = $result->fetch_object()){
	?>
		<div class="newsBodyContainer">
		    <div class="newsBodyHeader">
		    	<div class="dateItem">
		    		<?=date('d.m.Y', $obj->idate)?>
		    	</div>
		    	<div class="titleItem">
		    		<a onClick = (changePage(<?=$obj->id?>,'new'))><?=$obj->title?></a>
		    	</div>
		    </div>
		    <div class="announceItem">
		    	<?=$obj->announce?>
		    </div>
		</div>
	<?
	    }
	?>
	</div>
	<div>
		<div class="headerPaginationMenu">
			<p>Страницы:</p>
		</div>
		<div class="pagesStyle">
			<? 
				$query = "SELECT COUNT(*) FROM news";
				$newsSize = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
				$newsSize = mysqli_fetch_row($newsSize);
				$news = $newsSize[0];
				$totalCountPages = ceil($news / $pageSize);
				for ($i=1; $i<=$totalCountPages; $i++){
			?>
				<div id="<?=$i?>" class="pageNumberItem" onClick = "changePage(<?=$i?>,'page'); changeCurrentPage(<?=$i?>);" >
					<div><?=$i?></div>
				</div>
			<?
		}
	}
	?>
		</div>
	</div>
</div>

<?
	mysqli_close($link); 
?>
<?require_once('.\local\templates\footer.php');?>