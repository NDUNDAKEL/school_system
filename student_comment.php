<?php
include('Database Operations/connect.php');
echo "
    <div id='performance' style='display:flex; flex-direction:row;'>
    <form method='POST' action='student_comment.php' id='formemoji'>
    <textarea rows='5' cols='50' name='commentperformance' placeholder='Write a comment on how you have performed'></textarea>
    <button name='comment' type='submit'>Send Comment</button>
    <div id='student_comment'>
<p>Student comment<p>
    <div>
        <div>
</form>
    
</div>
";
$comment=filter_input(INPUT_POST,'commentperformance',FILTER_SANITIZE_SPECIAL_CHARS);
if(isset($_POST['comment'])){
    echo $comment;
}
?>