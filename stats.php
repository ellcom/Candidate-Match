<?php
define("AMOUNT_OF_OPTIONS", 5);

class stats 
{
	public $data;

	// CONSTRUCTOR
	function __construct($data) 
	{
		$this->data=$data;
	}

	// DESTRUCTOR
	function __destruct()
	{
		$data = NULL;
	}

	// FUNCTION getTotalVoters
	// ==================================================
	// Gets the total number of voters from the data.
	public function getTotalVoters()
	{
		if ($this->data == NULL) {return 0;}

		$totalVoters = 0;	
		
		for($i = 0; $i < AMOUNT_OF_OPTIONS; $i++)
		{
			$totalVoters += $this->data[$i];
		}
		
		return $totalVoters;
	}
	// ==================================================
	// END FUNCTION getTotalVoters


	// FUNCTION getAverageVoters
	// ==================================================
	// Gets the average amount of voters for each option
	public function getAverageVoters()
	{
		return $this->getTotalVoters()/AMOUNT_OF_OPTIONS;
	}
	// ==================================================
	// END FUNCTION getAverageVoters


	// FUNCTION getTotalVoteStrength
	// ==================================================
	// Gets the total number of voters from the data.
	public function getTotalVoteStrength()
	{
		if ($this->data == NULL) {return 0;}

		$totalVoteStrength = 0;

		for($i = 0; $i < AMOUNT_OF_OPTIONS; $i++)
		{
			$totalVoteStrength += ($this->data[$i] * ($i+1));
		}

		return $totalVoteStrength;
	}
	// ==================================================
	// END FUNCTION getTotalVoteStrength


	// FUNCTION getAverageVoteStrength
	// ==================================================
	// Gets the average vote strength (referring to the
	// value of the vote 1-5)
	public function getAverageVoteStrength()
	{
		$totalStrength = $this->getTotalVoteStrength();
		$totalVoters =$this->getTotalVoters();

		if ($totalVoters == 0) {return 0;}

		return $totalStrength/$totalVoters;
	}
	// ==================================================
	// END FUNCTION getAverageVoteStrength


	// FUNCTION getStandardDeviation
	// ==================================================
	// Calculates the standard deviation of the dataset
	public function getStandardDeviation()
	{
		if ($this->data == NULL) {return 0;}

		$stdDev = 0;
		$average = $this->getAverageVoters();

		for($i = 0; $i < sizeof($this->data); $i++)
		{
			$stdDev += pow($this->data[$i] - $average, 2);
		}

		$standardDeviation = sqrt($stdDev/(sizeof($this->data)));

		return $standardDeviation;
	}
	// ==================================================
	// END FUNCTION getStandardDeviation


	// FUNCTION getBias
	// ==================================================
	// Calculates the bias of the inputs. Positive bias
	// shows bias towards agreement, negative values show
	// bias towards disagreement.
	public function getBias()
	{
		if ($this->data == NULL || $this->getTotalVoters() == 0) {return 0;}

		$bias = 0;
		$biasModifier = -2;

		for($i = 0; $i < AMOUNT_OF_OPTIONS; $i++)
		{
			$bias += ($biasModifier * ($this->data[$i]/$this->getTotalVoters()));
			$biasModifier++;
		}

		return $bias;
	}
	// ==================================================
	// END FUNCTION getBias


	// FUNCTION getDivisiveness
	// ==================================================
	// returns a value from 0 to 4 corresponding to the
	// divisiveness of a question. The closer to zero,
	// the less divisive the question is.
	public function getDivisiveness()
	{
		if ($this->data == NULL) {return 0;}

		$totalAvg = 0;
		$avgVote = $this->getAverageVoteStrength();
		$zeroCount = 0;

		for($i = 0; $i < AMOUNT_OF_OPTIONS; $i++)
		{
			if ($this->data[$i] == 0) 
			{
				$zeroCount++;
			}
			$totalAvg += ($avgVote - ($i+1));
		}


		if ($zeroCount >= 4)
		{
			$divisiveness = 4;
		}
		else
		{
			$divisiveness = $this->getStandardDeviation()*abs($totalAvg)/$this->getTotalVoters();
		}

		return $divisiveness;
	}
	// ==================================================
	// END FUNCTION getDivisiveness
}

?>