<? include "../../header.php"; if ($user){ ?>
<div class="container" style="width:100%;">
<div class="content-box">
<table width="100%">
<tbody><tr>
<td width="35%" style="text-align:right;">
Username
</td>
<td style="padding-left:25px !important;">
<input type="text" id="username" class="general-textarea" style="width:200px;" value="" disabled="">
<div style="font-size:11px;color:#999;">Changing your username costs <font style="color:#15BF6B;">$250 Cash</font>.</div>
</td>
</tr>
<tr>
<td width="35%" style="text-align:right;">
Email
</td>
<td style="padding-left:25px !important;">
<input type="text" id="email" class="general-textarea" style="width:200px;" placeholder="">
<div style="font-size:11px;color:#999;">Your email helps keep your account secure.</div>
</td>
</tr>
<tr>
<td width="35%" style="text-align:right;">
Gender
</td>
<td style="padding-left:25px !important;">
<select id="gender" class="browser-default general-textarea" style="width:200px;">
<option value="0" selected="">Male</option>
<option value="1">Female</option>
</select>
</td>
</tr>
<tr>
<td width="35%" style="text-align:right;">
Birth Date
</td>
<td style="padding-left:25px !important;">
<select id="birthdate_month" class="browser-default general-textarea" style="display:inline-block;width:108px;">
<option value="0" selected="">Select...</option>
<option value="1">January</option>
<option value="2">February</option>
<option value="3">March</option>
<option value="4">April</option>
<option value="5">May</option>
<option value="6">June</option>
<option value="7">July</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
<select id="birthdate_day" class="browser-default general-textarea" style="display:inline-block;width:88px;">
<option value="0" selected="">Select...</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>
</select>
<div style="height:10px;"></div>
<select id="birthdate_year" class="browser-default general-textarea" style="width:98px;">
<option value="0" selected="">Select...</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option>
</select>
</td>
</tr>
<tr>
<td width="35%" style="text-align:right;">
Country
</td>
<td style="padding-left:25px !important;">
<select id="country" class="browser-default general-textarea" style="width:200px;">
<option value="AF">Other</option>
<option value="AX">United Kingdom</option>
<option value="AL">United States</option>
</select>
</td>
</tr>
</tbody></table>
</div>

<form action="" method="post">
<input type="text" name="post" id="post" class="general-textarea" placeholder="Blurb Body">

<div style="height:15px;"></div>
<button type="submit" name="save" class="waves-effect waves-light btn light-blue darken-2" style="display:block;">Post</button>
</form>

<?
function is_alphanumeric($body) {
return (bool)preg_match("/^([a-zA-Z0-9])+$/i", $body);
}

if(isset($_POST['save'])){
$post = $_POST["post"];
$body = $post;
if(is_alphanumeric($body)){
$hi = $handler->query("UPDATE users SET `description`='$post' WHERE id='$myu->id'");
header("Location: /Personal/Settings");
} } }
include "../../footer.php"; ?>