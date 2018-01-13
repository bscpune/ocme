function amountSeperateByComma(x){
x=x.toString();
var lastThree = x.substring(x.length-3);
var otherNumbers = x.substring(0,x.length-3);
if(otherNumbers != '')
    lastThree = ',' + lastThree;
var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
return res;
}
function ucwords(str) {
  return (str + '')
    .replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {
      return $1.toUpperCase();
    });
}
