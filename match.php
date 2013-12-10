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
	// their similarity value sorted in ascending order,
	function calculateDifferences()
	{
		$candidateDiffs = NULL;
		$localCount = 0;

		foreach ($this->candidateData as $candidateAnswer) 
		{
			if ($candidateDiffs == NULL)
			{
				$candidateDiffs[] = array('candidateID'=> $candidateAnswer['candidateID'],'similarity'=>0);
			}
			else
			{
				foreach ($candidateDiffs as $difference)
				{
					//echo $candidateAnswer['candidateID'].' '.$difference['candidateID'].'<br>';
					if ($candidateAnswer['candidateID'] == $difference['candidateID'])
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
					$candidateDiffs[] = array('candidateID'=> $candidateAnswer['candidateID'],'similarity'=>0);
				}	
				else
				{
					//echo 'Candidate in array';
				}
			}

			$count = 0;

			foreach ($candidateDiffs as $difference) 
			{
				//echo 'count: '.$count.' ans: '.$candidateAnswer['candidateID'].' candDiffs: '.$difference['candidateID'].'<br>';
				if ($candidateAnswer['candidateID'] == $difference['candidateID']) 
				{
					$q = $candidateAnswer['questionID'];

					foreach ($this->localData as $local) 
					{
						if ($q == $local['questionID']) 
						{
							$diff = abs($local['answer'] - $candidateAnswer['answer']);  

							$candidateDiffs[$count]['similarity'] += $diff;
							//echo $candidateDiffs[$count]['similarity'].' ';
						}
					}
				}
				$count++;
			}
			$count = 0;	
		}

		// convert the difference value into a percentage depending
		// on the amount of questions and the similarity value
		// CHANGE TO 80 FOR 20 Q's!
		$maxDiff = 40;

		for ($i=0; $i < sizeof($candidateDiffs); $i++) 
		{ 
			echo 'diff: '.$candidateDiffs[$i]['similarity'].'<br>';
			$percentage = ((($maxDiff-$candidateDiffs[$i]['similarity'])/$maxDiff)*100);
			echo $percentage.'%<br>';

			$candidateDiffs[$i]['similarity'] = $percentage;
		}

		// swap item1 and item2 around in function to reverse order.
		function similarity_sort($a, $b)
		{
			return $a['similarity']<$b['similarity'];
		}

		usort($candidateDiffs, 'similarity_sort');

		return $candidateDiffs;
	}
	// ==================================================
	// END FUNCTION calculateDifferences

}

?>