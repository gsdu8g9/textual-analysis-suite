function GetIC() {
    plaintext = document.getElementById("p").value.toLowerCase().replace(/[^a-z]/g, "");
    var counts = new Array(26);
    var totcount=0;
    for(i=0; i<26; i++)
	{
	    counts[i] = 0;
	}

    for(i=0; i<plaintext.length; i++)
    {
	counts[plaintext.charCodeAt(i) - 97]++;
	totcount++;
    }

    var sum = 0;

    for(i=0; i<26; i++)
	{
	    sum = sum + counts[i]*(counts[i]-1);
	}
    ic = sum / (totcount*(totcount-1));
    document.getElementById("ic").value = ic;
    document.getElementById("count").value = totcount;
} 


sub
wmzfxtdhzfngfwxwnwxjevxdmzoxfkvxdmzowmkwmkfgzzexenfzpjotkebmneloz
lfjpbzkofxwvjefxfwfjpfngfwxwnwxeszyzobdhkxewzawvmkokvwzopjoklxppz
ozewvxdmzowzawvmkokvwzoxwlxppzofpojtvkzfkovxdmzoxewmkwwmzvxdmzokh
dmkgzwxfejwfxtdhbwmzkhdmkgzwfmxpwzlxwxfvjtdhzwzhbrntghzl


vin

vptzmdrttzysubxaykkwcjmgjmgpwreqeoiivppalrujtlrzpchljftupucywvsyi
uuwufirtaxagfpaxzxjqnhbfjvqibxzpotciiaxahmevmmagyczpjxvtndyeuknul
vvpbrptygzilbkeppyetvmgpxuknulvjhzdtgrgapygzrptymevppaxygkxwlvtia
wlrdmipweqbhpqgngioirnxwhfvvawpjkglxamjewbwpvvmafnlojalh


function GetCS() 
{
    plaintext = document.getElementById("p").value.toLowerCase().replace(/[^a-z]/g, "");
    var counts = new Array(26);
    var expected = [0.08167,0.01492,0.02782,0.04253,0.12702,0.02228,0.02015,0.06094,0.06966,0.00153,0.00772,
		    0.04025,0.02406,0.06749,0.07507,0.01929,0.00095,0.05987,0.06327,0.09056,0.02758,0.00978,
		    0.02360,0.00150,0.01974,0.00074];
    var totcount=0;
    for(i=0; i<26; i++)
    {
	counts[i] = 0;
    }

    for(i=0; i<plaintext.length; i++)
    {
	counts[plaintext.charCodeAt(i) - 97]++;
	totcount++;
    }
    var sum1 = 0.0;
    for(i=0; i<26; i++)
	{
	    sum1 = sum1 + Math.pow((counts[i] - totcount*expected[i]),2)/(totcount*expected[i]);
	}

    var sum2 = 0.0;

    for(i=0; i<26; i++)
    {
	sum2 = sum2 + Math.pow((counts[i] - totcount/26),2)/(totcount/26.0);
    }

} 
