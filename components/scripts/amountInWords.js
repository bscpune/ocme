function toWords(number)
{
   if ((number < 0) || (number > 999999999))
    {
    return "Number is out of range";
    }
    var Gn = Math.floor(number / 10000000);  /* Crore */
    number -= Gn * 10000000;
    var kn = Math.floor(number / 100000);     /* lakhs */
    number -= kn * 100000;
    var Hn = Math.floor(number / 1000);      /* thousand */
    number -= Hn * 1000;
    var Dn = Math.floor(number / 100);       /* Tens (deca) */
    number = number % 100;               /* Ones */
    var tn= Math.floor(number / 10);
    var one=Math.floor(number % 10);
    var res = "";

    if (Gn>0)
    {
        res += (toWords(Gn) + " Crore");
    }
    if (kn>0)
    {
            res += (((res=="") ? "" : " ") +
            toWords(kn) + " Lakh");
    }
    if (Hn>0)
    {
        res += (((res=="") ? "" : " ") +
            toWords(Hn) + " Thousand");
    }

    if (Dn)
    {
        res += (((res=="") ? "" : " ") +
            toWords(Dn) + " hundred");
    }


    var ones = Array("", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen","Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen","Nineteen");
var tens = Array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty","Seventy", "Eigthy", "Ninety");
   
    if (tn>0 || one>0)
    {
        if (!(res==""))
        {
            res += " ";
        }
        if (tn < 2)
        {
            res += ones[tn * 10 + one];
        }
        else
        {

            res += tens[tn];
            if (one>0)
            {
                res += (" " + ones[one]);
            }
        }
    }
   
    if (res=="")
    {
        res = "zero";
    }
    return res;
}