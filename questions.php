<!DOCTYPE HTML>
<head>
<?
/*
* created by patricia curtis 01/09/2016
* patricia.curtis@luckyredfish.com
*/
	$DB_HOST	                =	"localhost";
	$DB_USER	                =    "REMOVED";
	$DB_PASS	                =	"REMOVED";
	$DB_NAME	                =	"REMOVED";

	$conn = mysql_connect($DB_HOST, $DB_USER, $DB_PASS);
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}

	$db_selected = mysql_select_db($DB_NAME, $conn);
	if (!$db_selected) 
	{
	    die ("Can\'t use $DB_NAME : " . mysql_error());
	}
	$SQL	=	"SELECT question, answer1, answer2, answer3, answer4 FROM quiz  AS r1 JOIN (SELECT CEIL(RAND() * (SELECT MAX(questionId) FROM quiz)) AS questionId) AS r2 WHERE r1.questionId >= r2.questionId ORDER BY r1.questionId ASC LIMIT 12";
	$result = mysql_query($SQL);
?>
</head>
<body style="height:100%" onclick="NextState();" onresize="ScaleScreen();">
	<!-- <div id="debug" style="font-size:20px;font-weight:bolder;color:white;"></div>	-->
	<script>
		var	Question	=	[]; 
		var	Answers	=	[];  
		var	Subject	=	[];
	

<?	     
		$count	=	0;
		while ($row = mysql_fetch_array($result)) 
		{
		    echo "\t\tSubject[".$count."]\t=\t".rand(0,7).";\n";
			echo "\t\tQuestion[".$count."]\t=\t\"".$row['question']."\";\n";
			echo "\t\tAnswers[".$count."]\t=\t[\"".str_replace("{","!",str_replace("}","",$row['answer1']))."\", \"".str_replace("{","!",str_replace("}","",$row['answer2']))."\",\"".str_replace("{","!",str_replace("}","",$row['answer3']))."\",\"".str_replace("{","!",str_replace("}","",$row['answer4']))."\"];\n";
			$count++;
		}
        echo "var\tCount\t=\t".$count.";"; 
?>	
    	function MoveQuestions() 
        {
            for(var q=0;q<Count;q++)
            {
                parent.Subject[q]=  Subject[q];
                parent.Question[q]=  Question[q];
                parent.Answers[q]=  Answers[q];
            }
            parent.QuestionCount   =   Count;
            parent.KickitOff();
		}

    
    window.setTimeout(MoveQuestions,200);
	</script>
</body>
</html>
