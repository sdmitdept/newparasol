<div class="questionanswer-box" id="answercont-<?php echo $question_id ?>">
	<p class="userdate"><span><?php echo $name ?></span> . <?php echo date("M y",strtotime($qdate)) ?></p>
	<h1><?php echo $question ?></h1>

	<div class="answer" id="answer-<?php echo $question_id ?>">
		<?php echo $answer ?>
	</div>


	

	<button onclick="expand_answer(this)" class="btn btn-white btn-white-border">Baca Selengkapnya</button>

</div>