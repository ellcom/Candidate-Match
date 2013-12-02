<?php

class match
{
	public $candidateData; // stores voters session data
	public $localData; // local answers from session

	// CONSTRUCTOR
	function __construct($candidateData, $localData) 
	{
		$this->candidateData=$candidateData;
		$this->localData=$localData;
	}

	// DESTRUCTOR
	function __destruct()
	{
		$candidateData = NULL;
		$localData = NULL;
	}


	// FUNCTION calculateDifferences
	// ==================================================
	// returns a 2D array containing the candidate ID and
	// their difference value sorted in ascending order,
	public function calculateDifferences() 
	{
		$candidateDiffs = NULL;

		// for each candidateAnswer record
		for ($i=0; $i < sizeof($this->candidateData); $i++) 
		{ 
			// determine if an array exists for the question already - if not, add one
			if ($candidateDiffs == NULL)
			{
				//echo 'Candidate not in array yet - adding Candidate<br>';
				$candidateDiffs[] = array('candidateID'=> $this->candidateData[$i]['candidateID'], 'difference'=>0); 
			}
			else
			{
				// check if an array exists
				for ($j=0; $j < sizeof($candidateDiffs); $j++) { 
					if ($this->candidateData[$i]['candidateID'] == $candidateDiffs[$j]['candidateID'])
					{
						$found = true;
						break;
					}
					else // not found yet
					{
						$found = false;
					}
				}
				// if not found, create a new array to store the data.
				if ($found == false)
				{
					//echo 'Candidate not in array yet - adding Candidate<br>';
					$candidateDiffs[] = array('candidateID'=> $this->candidateData[$i]['candidateID'], 'difference'=>0); 
				}
			}

			// adjust the according difference
			for ($j=0; $j < sizeof($candidateDiffs); $j++) { 
				if ($this->candidateData[$i]['candidateID'] == $candidateDiffs[$j]['candidateID']) 
				{
					$q = $this->candidateData[$i]['questionID'];
					$diff = abs($this->localData[$q-1] - $this->candidateData[$i]['answer']);  

					$candidateDiffs[$j]['difference'] += $diff;

					//echo $candidateDiffs[$j]['difference'].' ';
				}
			}
		}

		// swap item1 and item2 around in function to reverse order.
		usort($candidateDiffs, function ($item1, $item2) {return $item1['difference'] - $item2['difference'];});

		return $candidateDiffs;
	}
	// ==================================================
	// END FUNCTION calculateDifferences

}

?>