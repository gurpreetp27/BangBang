
<form method="POST" action="https://www.klikandpay.com/paiement/order1.pl" accept-charset="UTF8" id="knp-form" target="_top">
<table border="0" cellpadding="2" cellspacing="0" width="20%">
<meta charset="UTF-8">
<tr>
<td width="50%">Surname:</td>
<td width="50%"><input type="text" name="NOM" size="24" value="{{$data['last_name']}}ssss"></td>
</tr>
<tr>
<td width="50%">First name:</td>
<td width="50%"><input type="text" name="PRENOM" size="24" value="{{$data['name']}}dddd"></td>
</tr>
<tr>
<td width="50%">Address:</td>
<td width="50%"><input type="text" name="ADDRESSE" size="24" value="asdfsf"></td>
</tr>
<tr>
<td width="50%">Postcode:</td>
<td width="50%"><input type="text" name="CODEPOSTAL" size="24" value="asdfsa"></td>
</tr>
<tr>
<td width="50%">Town:</td>
<td width="50%"><input type="text" name="VILLE" size="24" value="adsfsadf"></td>
</tr>
<tr>
<td width="50%">Country:</td>
<td width="50%"><select size="1" name="PAYS">
<option value="DE" selected="selected">Switzerland</option>
<option value="FR">France</option>
</select>
</td>
</tr>
<tr>
<td width="50%">Tel:</font></td>
<td width="50%"><input type="text" name="TEL" size="24" value="7845123256"></td>
</tr>
<tr>
<td width="50%">E-mail:</font></td>
<td width="50%"><input type="text" name="EMAIL" size="24" value="{{$data['email']}}"></td>
</tr>
<input type="hidden" name="ID" value="1567077525">
<input type="hidden" name="RETOUR" value="http://50.116.49.118/test2.php?cvb">
<input type="hidden" name="RETURN" value="http://50.116.49.118/bangbang?id=786">
<input type="hidden" name="ABONNEMENT" value="<?php echo $data['sub_id']; ?>">
<tr>
<td width="100%" colspan="2">
<p align="center"><input type="submit" value="Send" name="B1"></p></td>
</tr>
</table>