function GetIC() {
plaintext = document.getElementById("p").value.toLowerCase().replace(/[^a-z]/g, "");
var counts = new Array(26);
var totcount=0;
for(i=0; i<26; i++) counts[i] = 0;
for(i=0; i<plaintext.length; i++){
counts[plaintext.charCodeAt(i) - 97]++;
totcount++;
}
var sum = 0;
for(i=0; i<26; i++) sum = sum + counts[i]*(counts[i]-1);
ic = sum / (totcount*(totcount-1));
document.getElementById("ic").value = ic;
document.getElementById("count").value = totcount;
} 
