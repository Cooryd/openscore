<?

include("db_connect.php");

include("header.php");
$doi = $_GET['doi'];
$doi = preg_replace('/^.+doi\.org\//', '', $doi);

if(!isset($_GET['doi'])){
  dispHeader("OpenScore");
  ?>
  <div style="text-align:center">
  
  <h1 style="color:black; font-size:20px;">Search for a DOI</h1>
  <div>
    <form action="./">
      <input name = "doi" type="text" value="">
      <input type="submit" value="Search">
    </form>
  </div>


  
  <h1 style="color:black; font-size:20px;">Recent activity</h1>

  <?
  /**
 * Calculates a human-friendly string describing how long ago a timestamp occurred.
 *
 * @link http://stackoverflow.com/a/2916189/3923505
 *
 * @param int $timestamp The timestamp to check.
 * @param int $now       The current time reference point.
 *
 * @return string The time ago in a human-friendly format.
 *
 * @throws \Exception if the timestamp is in the future.
 */
function time_ago( $timestamp = 0, $now = 0 ) {

    // Set up an array of time intervals.
    $intervals = array(
        60 * 60 * 24 * 365 => 'year',
        60 * 60 * 24 * 30  => 'month',
        60 * 60 * 24 * 7   => 'week',
        60 * 60 * 24       => 'day',
        60 * 60            => 'hour',
        60                 => 'minute',
        1                  => 'second',
    );

    // Get the current time if a reference point has not been provided.
    if ( 0 === $now ) {
        $now = time();
    }

    // Make sure the timestamp to check predates the current time reference point.
    if ( $timestamp > $now ) {
        throw new \Exception( 'Timestamp postdates the current time reference point' );
    }

    // Calculate the time difference between the current time reference point and the timestamp we're comparing.
    $time_difference = (int) abs( $now - $timestamp );

    // Check the time difference against each item in our $intervals array. When we find an applicable interval,
    // calculate the amount of intervals represented by the the time difference and return it in a human-friendly
    // format.
    foreach ( $intervals as $interval => $label ) {

        // If the current interval is larger than our time difference, move on to the next smaller interval.
        if ( $time_difference < $interval ) {
            continue;
        }

        // Our time difference is smaller than the interval. Find the number of times our time difference will fit into
        // the interval.
        $time_difference_in_units = round( $time_difference / $interval );

        if ( $time_difference_in_units <= 1 ) {
            $time_ago = sprintf( 'one %s ago',
                $label
            );
        } else {
            $time_ago = sprintf( '%s %ss ago',
                $time_difference_in_units,
                $label
            );
        }

        return $time_ago;
    }
}

$sql = "SELECT *,questions.question AS question_text FROM ratings INNER JOIN papers ON papers.doi = ratings.doi INNER JOIN questions ON questions.id = ratings.question ORDER BY timestamp DESC LIMIT 20";
$result = mysqli_query($link, $sql);
while($row = mysqli_fetch_assoc($result)){
 // print_r($row);

  ?>
  <div class="recent_update"><span class="question_text">&ldquo;<?= $row['question_text'] ?>&rdquo;</span> was answered for <a href="/?doi=<?= urlencode($row['doi'])?>"><?= $row['title'] ?></a> <?= time_ago($row['timestamp']) ?></div>
  <?  }
  ?>

  </div>
</div>
  <?
  dispFooter();

}
else{





?>
<style>
 
  div.responses{margin-top:10px; color: #505050;}
  button {background:lightgrey;}
  </style>
<script>
var http = new XMLHttpRequest();
var host = "";

function sendAnswer(doi,question, answer) {
 
  data = {'question':question, 'answer': answer,'doi': doi};


  query =  $.ajax({
  type: "POST",
  url: "add_rating.php",
  data: data,
  success : function(data){
    console.log(data);
    if(data=="need_orcid"){

       $('#quest'+question).html("<span style='font-size:14px'>Please <a href='orcid-signin.php?redirect="+encodeURI(window.location)+"'>sign in with ORCid</a> to vote.</span>")

    }
    else{
      $('#quest'+question).html("<span style='font-size:10px'>Thank you, your rating has been recorded.</span>");

    }
  },
  error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
});



}
</script>



<?php
//$doi = (isset($_GET["doi"]) && $_GET["doi"] != "" ? $_GET["doi"] : "10.1037/0022-3514.65.6.1190");

$debug = (isset($_GET["debug"]) ? true : false);
function doi_url($doi)
{
  return "http://dx.doi.org/" . $doi;
  //return "http://data.crossref.org/" . $doi;
}
function get_curl($url) 
{ 
  $curl = curl_init(); 
  $header[0] = "Accept: application/rdf+xml;q=0.5,"; 
  $header[0] .= "application/vnd.citationstyles.csl+json;q=1.0"; 
  curl_setopt($curl, CURLOPT_URL, $url); 
  curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)'); 
  curl_setopt($curl, CURLOPT_HTTPHEADER, $header); 
  curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com'); 
  curl_setopt($curl, CURLOPT_AUTOREFERER, true); 
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_TIMEOUT, 10); 
  $json = curl_exec($curl); 
  curl_close($curl); 
  return $json; 
}
function get_json_array($json)
{
  return json_decode($json, true);
}
function show_json($json, $debug=false) {
  if ($debug) {
    echo "<p>" . $json . "</p>";
  }
}
function show_json_array($json_array, $debug=false) {
  if ($debug) {
    echo "<pre class='json_array'>";
    print_r($json_array);
    echo "</pre>";
  }
}

function get_arrayed_citation($json_array, $doi, $doi_url)
{

  $title        = $json_array["title"];
  $author_array = $json_array["author"];
  $jtitle       = $json_array["container-title"];
  $pages        = $json_array["page"];
  $volume       = $json_array["volume"];
  $issue        = $json_array["issue"];
  $issn_array   = $json_array["ISSN"];
  $url          = $json_array["URL"];
  $year         = $json_array["issued"]["date-parts"][0][0];
  $citation  = "";
  $out_array = array();
  if($author_array != null){
  $author_count = count($author_array);
  $last = $author_count - 1;
  //$author_list[] = trim($author_array[0]["family"]) . ", " . trim($author_array[0]["given"]);
  for($i=0; $i<$last; $i++)
  {
    $author_list[] = trim($author_array[$i]["given"]) . " " . trim($author_array[$i]["family"]);
  }
  $author_list[] = "and " . trim($author_array[$last]["given"]) . " " . trim($author_array[$last]["family"]);
  $citation .= implode(", ", $author_list) . ". ";
  $citation .= "&ldquo;" . trim(str_replace(".", "", $title)) . ".&rdquo; ";
  //$citation .= "<em>" . trim(str_replace(".", "", $jtitle)) . "</em> ";
  $citation .= ($volume ? $volume : "");
  $citation .= ($issue ? ", no. " . $issue : "");
  $citation .= " (" . $year . ")";
  $citation .= ($pages ? ": " . $pages . ". " : ". ");
  $citation .= ($doi ? "doi:&nbsp;<a href='" . $doi_url . "'>" . $doi . "</a>" : "");

  
  $out_array['authors'] = implode(", ", $author_list);
  $out_array['date'] = implode("/", array_reverse($json_array["issued"]["date-parts"][0]));
  $out_array['title'] = $title;

   $out_array['journal'] = $jtitle;
  $out_array['doi_url'] = $doi_url;
  $out_array['doi'] = $doi;
  return $out_array;}

}

$doi_url      = doi_url($doi);
$json         = get_curl($doi_url);
$json_array   = get_json_array($json);
$paper_meta     = get_arrayed_citation($json_array, $doi, $doi_url);

if($paper_meta['title']==""){
  dispHeader("Error");
  ?>
  <div class="error">Sorry we could not find this DOI. :(</div>
  <?
  dispFooter();
  die();
}
$title = $paper_meta['title'];
if (!is_array($paper_meta['journal'])){
  $journal = $paper_meta['journal'];

}
else{
  $journal = "";

}


$date = $paper_meta['date'];
$authors = $paper_meta['authors'];
$sql = "INSERT INTO papers (title, journal, date, authors, doi) VALUES ('$title', '$journal', '$date', '$authors', '$doi')";
mysqli_query($link, $sql);

dispHeader($paper_meta['title']);
?>


<div id ="header">
 

  <h2 id="paper_title"><a href="<?= $paper_meta['doi_url'] ?>"><?= $paper_meta['title'] ?></a></h2>
  
  <div id="authors"><?= $paper_meta['authors'] ?></div>
   <div id="meta"><?
   if (!is_array($paper_meta['journal'])){ ?> <?= $paper_meta['journal'] ?>, <? } ?><?= $paper_meta['date'] ?>, <a class="doi" href="<?= $paper_meta['doi_url'] ?>">doi:<?= $doi ?></a></div>
</div>

<div id="ratings">
  <?

  function disp_question($row){
    global $doi;
    global $link;
    $question= $row['id'];
    $result = mysqli_query($link,"SELECT * FROM possible_answers WHERE possible_answers.question = $question ORDER BY answer_order");
    $sql = "SELECT possible_answers.answer_text AS answer,possible_answers.answer_color AS color, COUNT(*) AS count FROM `ratings` INNER JOIN possible_answers ON possible_answers.id = ratings.answer WHERE doi='$doi' AND ratings.question = $question GROUP BY possible_answers.id";
    
    $data = mysqli_query($link,$sql);

    ?>
    <h3 class="question-title" title="<?= $row['supplemental_info'] ?>"><?= $row['question'] ?></h3>

    <div style="display:flex;border-radius: 10px; overflow:hidden;">
    <?
    $counts = array();
    $texts =array();
    $colors=array();

    while($dat_row = mysqli_fetch_assoc($data)){
      $texts[]=$dat_row['answer'];
      $colors[] = $dat_row['color'];
      $counts[] = $dat_row['count'];
    }
    $total = array_sum($counts);

    for($i=0;$i<count($texts);$i++){
      ?>
      <div class="bar" style="width:<?= 100*$counts[$i]/$total  ?>%; background:<?= $colors[$i]  ?>"><div class="bar_gradient"> <? if($counts[$i]==1){ ?>
  1 person<? }  else{ ?>
        <?= $counts[$i]  ?> people <? } ?> answered <b><?= strtolower($texts[$i])  ?></b></div></div>
      <?
    }
    ?>
  </div>
<div id="quest<?= $row['id'] ?>" class="responses">Your answer: 
    <? while($answer_row=mysqli_fetch_assoc($result)){ ?>
    
      <button style="border:1px solid <?= $answer_row['answer_color'] ?>; border-radius:3px;" onclick="sendAnswer('<?= $doi ?>',<?= $row['id'] ?>,<?= $answer_row['id'] ?>)"><?= $answer_row['answer_text'] ?></button>
    
     
   
    <?
  }
  ?>
 </div>
  <?
  }
  $result = mysqli_query($link, "SELECT * FROM questions ORDER BY ordering");
  while($row = mysqli_fetch_assoc($result)){
    disp_question($row);

  }

  ?>

  </div>



<? 
dispFooter();
} ?>