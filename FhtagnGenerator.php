<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Cthuvian Ipsum Generator</title>
	<link rel="shortcut icon"  href="images/cthicon.ico" />
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
</head>

<body>

<div style="text-align:center">
<h1>Cthuvian Ipsum Generator
<g:plusone count="false"></g:plusone>
</h1>
</div>

<!-- Tables are the best thing in html ever -->
<div>
<table style="width:100%;" border="0">
<tr>
<td style="width:33%">

<form action="FhtagnGenerator.php">
<table>

<tr>
<td>Word count:</td>

<?php
	$iCount = $_GET['count'];

	if(empty($iCount) || !is_numeric($iCount)) $iCount = '500';
	if($iCount > 333333) $iCount = '333333';
	if($iCount < 1) $iCount = '1';

?>

<td><input id="count" name="count" type="text" value="<?php echo $iCount;?>"></td>
</tr>

<tr>
<td>Format: </td>
<td>
<select id="format" name="format">
<?php
	$iFormat = $_GET['format'];
	$formats = array('text', 'plain', 'html');
	if(empty($iFormat) || !in_array($iFormat, $formats))  $iFormat = 'text';

	echo '<option value="html"' . ($iFormat == 'html' ? ' selected' : '') . '>html</option>';
	echo '<option value="text"' . ($iFormat == 'text' ? ' selected' : '') . '>text</option>';
	echo '<option value="plain"' . ($iFormat == 'plain' ? ' selected' : '') . '>plain</option>';
?>
	
</select>
</td>
</tr>

<tr>
<td>Fixed first sentence:</td>
<td>

<?php
	$iFhtagn = $_GET['fhtagn'];

	if(empty($iFhtagn) || !checkBool($iFhtagn)) $iFhtagn = true;

	echo '<input type="radio" id="fhtagn" name="fhtagn" value="yes"' . ($iFhtagn ? ' checked': '') . '>Yes';
	echo '<input type="radio" id="fhtagn" name="fhtagn" value="no"' . (!$iFhtagn ? ' checked': '') . '>No';

?>
</td>
</tr>

<tr>
<td></td>
<td><input type="submit" value="Generate"/>
</tr>

</table>

</form>

</td>


<td style="text-align:center; width:33%">


<img src="images/cthulhu.png" style="align:center;"/>

</td>

<td style="width:33%">
A lorem ipsun generator based on <a href="http://www.hplovecraft.com/">H.P.Lovecraft's</a> <a href="http://en.wikipedia.org/wiki/Cthulhu_Mythos">Cthulhu Mythos</a><br/>
Code based on <a href="http://tinsology.net/">Mathew Tinsley's</a> <a href="http://tinsology.net/scripts/php-lorem-ipsum-generator/">PHP Lorem Ipsum</a><br/>
Wordlist from <a href="http://www.yog-sothoth.com/threads/8683-The-Complete-CTHUVIAN-ENGLISH-DICTIONARY">Cthuvian / English dictionary</a> at <a href="http://www.yog-sothoth.com">www.yog-sothoth.com</a> <a href="http://www.yog-sothoth.com/forum.php">forums</a><br/>
Source code at <a href="https://github.com/ken-tzu/Cthuvian-Ipsum-Generator/">Github</a><br/>.
Why lorem ipsum when you can Cthulhu fhtagn?

</td>

</tr>

</table>
</div>

<?php
if(!empty($_GET['count']))
{
	$generator = new FhtagnGenerator();

	echo '<tr><td colspan="3" style="height:70%;"><textarea rows=25 style="width:100%;">' .
	$generator->getContent($iCount, $iFormat, $iFhtagn) .
	'</textarea></td></tr>';
}
	
function checkBool(&$iFhtagn)
{
	if($iFhtagn == 'yes')
	{
		$iFhtagn = true;
		return true;
	}
	else if($iFhtagn == 'no')
	{
		$iFhtagn = false;
		return true;
	}
	else
	{
		return false;
	}
}	
?>

<div style="text-align:center">
	by <a href="mailto:akkadian+cthuvian@gmail.com">ephemer</a>
</div>


</body>
</html>


<?php
class FhtagnGenerator {
	/**
	*	Copyright (c) 2009, Mathew Tinsley (tinsley@tinsology.net)
	*	All rights reserved.
	*
	*	Redistribution and use in source and binary forms, with or without
	*	modification, are permitted provided that the following conditions are met:
	*		* Redistributions of source code must retain the above copyright
	*		  notice, this list of conditions and the following disclaimer.
	*		* Redistributions in binary form must reproduce the above copyright
	*		  notice, this list of conditions and the following disclaimer in the
	*		  documentation and/or other materials provided with the distribution.
	*		* Neither the name of the organization nor the
	*		  names of its contributors may be used to endorse or promote products
	*		  derived from this software without specific prior written permission.
	*
	*	THIS SOFTWARE IS PROVIDED BY MATHEW TINSLEY ''AS IS'' AND ANY
	*	EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	*	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	*	DISCLAIMED. IN NO EVENT SHALL <copyright holder> BE LIABLE FOR ANY
	*	DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	*	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	*	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
	*	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	*	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	*	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	*/
	
	private $words, $wordsPerParagraph, $wordsPerSentence, $prefix, $suffix, $start;
	
	function __construct($wordsPer = 100)
	{
		$this->wordsPerParagraph = $wordsPer;
		$this->wordsPerSentence = 24.460;
		$this->start = array(
		'Ph\'nglui',
		'mglw\'nafh',
		'Cthulhu',
		'R\'lyeh',
		'wgah\'nagl',
		'fhtagn.');
		
		$this->words = array(
		'Cthulhu',
		'R\'lyeh',
		'Dagon',
		'Hastur',
		'Yoggoth',
		'Nyarlathotep',
		'Shub-Niggurath',
		'Tsathoggua',
		'Azathoth',
		'Chaugnar Faugn',
		'ah',
		'\'ai',
		'athg',
		'\'bthnk',
		'bug',
		'ch\'',
		'chtenff',
		'ebunma',
		'ee',
		'ehye',
		'ep',
		'\'fhalma',
		'fhtagn',
		'fm\'latgh',
		'ftaghu',
		'geb',
		'gnaiih',
		'gof\'nn',
		'goka',
		'gotha',
		'grah\'n',
		'hafh\'drn',
		'hai',
		'hlirgh',
		'hrii',
		'hupadgh',
		'ilyaa',
		'k\'yarnak',
		'kadishtu',
		'kn\'a',
		'li\'hee',
		'llll',
		'lloig',
		'lw\'nafh',
		'mg',
		'mnahn\'',
		'n\'gha',
		'n\'ghft',
		'nglui',
		'nilgh\'ri',
		'nog',
		'nw',
		'ooboshu',
		'orr\'e',
		'phlegeth',
		'r\'luh',
		'ron',
		's\'uhn',
		'sgn\'wahl',
		'shagg',
		'shogg',
		'shtunggli',
		'shugg',
		'sll\'ha',
		'stell\'bsna',
		'syha\'h',
		'tharanak',
		'throd',
		'uaaah',
		'uh\'e',
		'uln',
		'vulgtlagln',
		'vulgtm',
		'wgah\'n',
		'y\'hah',
		'ya',
		'zhro');
		
		$this->prefix = array(
			'c',
			'f\'',
			'h\'',
			'na',
			'nafl',
			'ng',
			'nnn',
			'ph\'',
			'y-');
			
		$this->suffix = array(
			'agl',
			'nyth',
			'og',
			'or',
			'oth',
			'yar');
	}
	
	function getContent($count, $format = 'html', $fhtagn = true)
	{
		$format = strtolower($format);
		
		if($count <= 0)
			return '';

		switch($format)
		{
			case 'text':
				return $this->getText($count, $fhtagn);
			case 'plain':
				return $this->getPlain($count, $fhtagn);
			default:
				return $this->getHTML($count, $fhtagn);
		}
	}
	
	private function getWords(&$arr, $count, $fhtagn)
	{
		$i = 0;
		
		if($fhtagn)
		{
			$j = 0;
			for($j; $j < count($this->start); $j++)
			{
				$arr[$j] = $this->start[$j];
			}
			$i = count($this->start);
		}
		
		for($i; $i < $count; $i++)
		{
			$index = array_rand($this->words);
			$word = $this->words[$index];
			
			//echo $index . '=>' . $word . '<br />';
			
			if($i > 0 && $arr[$i - 1] == $word)
				$i--;
			else
			{
				if(mt_rand(0,99) > 79)
					$word = $this->prefix[array_rand($this->prefix)] . $word;
				else if(mt_rand(0,99) > 89)
					$word .= $this->suffix[array_rand($this->suffix)];
					
				if($fhtagn && $i == count($this->start)) $word = ucfirst($word);	
					
				$arr[$i] = $word;
			}
		}
	}
	
	private function getPlain($count, $fhtagn, $returnStr = true)
	{
		$words = array();
		$this->getWords($words, $count, $fhtagn);
		//print_r($words);
		
		$delta = $count;
		$curr = 0;
		$sentences = array();
		while($delta > 0)
		{
			$senSize = $this->gaussianSentence();
			//echo $curr . '<br />';
			if(($delta - $senSize) < 4)
				$senSize = $delta;

			$delta -= $senSize;
			
			$sentence = array();
			for($i = $curr; $i < ($curr + $senSize); $i++)
				$sentence[] = $words[$i];

			$this->punctuate($sentence);
			$curr = $curr + $senSize;
			$sentences[] = $sentence;
		}
		
		if($returnStr)
		{
			$output = '';
			foreach($sentences as $s)
				foreach($s as $w)
					$output .= $w . ' ';
					
			return $output;
		}
		else
			return $sentences;
	}
	
	private function getText($count, $fhtagn)
	{
		$sentences = $this->getPlain($count, $fhtagn, false);
		$paragraphs = $this->getParagraphArr($sentences);
		
		$paragraphStr = array();
		foreach($paragraphs as $p)
		{
			$paragraphStr[] = $this->paragraphToString($p);
		}
		
		$paragraphStr[0] = "\t" . $paragraphStr[0];
		return implode("\n\n\t", $paragraphStr);
	}
	
	private function getParagraphArr($sentences)
	{
		$wordsPer = $this->wordsPerParagraph;
		$sentenceAvg = $this->wordsPerSentence;
		$total = count($sentences);
		
		$paragraphs = array();
		$pCount = 0;
		$currCount = 0;
		$curr = array();
		
		for($i = 0; $i < $total; $i++)
		{
			$s = $sentences[$i];
			$currCount += count($s);
			$curr[] = $s;
			if($currCount >= ($wordsPer - round($sentenceAvg / 2.00)) || $i == $total - 1)
			{
				$currCount = 0;
				$paragraphs[] = $curr;
				$curr = array();
				//print_r($paragraphs);
			}
			//print_r($paragraphs);
		}
		
		return $paragraphs;
	}
	
	private function getHTML($count, $fhtagn)
	{
		$sentences = $this->getPlain($count, $fhtagn, false);
		$paragraphs = $this->getParagraphArr($sentences);
		//print_r($paragraphs);
		
		$paragraphStr = array();
		foreach($paragraphs as $p)
		{
			$paragraphStr[] = "<p>\n" . $this->paragraphToString($p, true) . '</p>';
		}
		
		//add new lines for the sake of clean code
		return implode("\n", $paragraphStr);
	}
	
	private function paragraphToString($paragraph, $htmlCleanCode = false)
	{
		$paragraphStr = '';
		foreach($paragraph as $sentence)
		{
			foreach($sentence as $word)
				$paragraphStr .= $word . ' ';
				
			if($htmlCleanCode)
				$paragraphStr .= "\n";
		}		
		return $paragraphStr;
	}
	
	/*
	* Inserts commas and periods in the given
	* word array.
	*/
	private function punctuate(& $sentence)
	{
		$count = count($sentence);
		$sentence[$count - 1] = $sentence[$count - 1] . '.';
		$sentence[0] = ucfirst($sentence[0]);
		
		if($count < 4)
			return $sentence;
		
		$commas = $this->numberOfCommas($count);
		
		for($i = 1; $i <= $commas; $i++)
		{
			$index = (int) round($i * $count / ($commas + 1));
			
			if($index < ($count - 1) && $index > 0)
			{
				$sentence[$index] = $sentence[$index] . ',';
			}
		}
	}
	
	/*
	* Determines the number of commas for a
	* sentence of the given length. Average and
	* standard deviation are determined superficially
	*/
	private function numberOfCommas($len)
	{
		$avg = (float) log($len, 6);
		$stdDev = (float) $avg / 6.000;
		
		return (int) round($this->gauss_ms($avg, $stdDev));
	}
	
	/*
	* Returns a number on a gaussian distribution
	* based on the average word length of an english
	* sentence.
	* Statistics Source:
	*	http://hearle.nahoo.net/Academic/Maths/Sentence.html
	*	Average: 24.46
	*	Standard Deviation: 5.08
	*/
	private function gaussianSentence()
	{
		$avg = (float) 24.460;
		$stdDev = (float) 5.080;
		
		return (int) round($this->gauss_ms($avg, $stdDev));
	}
	
	/*
	* The following three functions are used to
	* compute numbers with a guassian distrobution
	* Source:
	* 	http://us.php.net/manual/en/function.rand.php#53784
	*/
	private function gauss()
	{   // N(0,1)
		// returns random number with normal distribution:
		//   mean=0
		//   std dev=1
		
		// auxilary vars
		$x=$this->random_0_1();
		$y=$this->random_0_1();
		
		// two independent variables with normal distribution N(0,1)
		$u=sqrt(-2*log($x))*cos(2*pi()*$y);
		$v=sqrt(-2*log($x))*sin(2*pi()*$y);
		
		// i will return only one, couse only one needed
		return $u;
	}

	private function gauss_ms($m=0.0,$s=1.0)
	{
		return $this->gauss()*$s+$m;
	}

	private function random_0_1()
	{
		return (float)rand()/(float)getrandmax();
	}
} // class
?>





