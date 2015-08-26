
<h2>TTSS Voting system</h2>

<?php
echo $this->Form->create('Vote');
echo $this->Form->input('vote_option', array(
	'label' => 'I vote for',
	//'type' => 'radio',
	'empty' => 'Select...',
	'options' => array('1' => 'Korgi', '2' => 'Jammu')));

echo $this->Form->input('free_text', array(
	'label' => 'Free text/arguments', 
	'type' => 'textarea')
);

echo $this->Form->input('email', array(
	'label' => 'Email', 
	'type' => 'email',
	'after' => "Use the same email address that you have given to our member list ".
			   "when paying the member fee<br> ".
			   "Vote will be validated by confirmation email."
));

echo $this->Form->input('magic_word', array(
	'label' => 'Give the Magic Word: (spam bot filter)',
));

echo $this->Form->end('Save my vote');

?>