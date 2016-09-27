<html>
<head>
	<title>Security Warning</title>
	<style type="text/css">
html, body {
	background: #0b1933;
	text-align: center;
}
body {
	font: 80% Tahoma;
}
#wrapper {
	margin: 100px auto;
	width: 500px;
	text-align: left;
	background: #fff;
	padding: 10px;
   border: 5px solid #ccc;
}
form { 
   text-align: center;
}
	</style>
   <base href="<?php echo GLYPE_URL; ?>/">
</head>
<body>
	<div id="wrapper">
		<h1>警告
	    !</h1>
		<p>你试图浏览的网站是在一个安全的连接。这个代理不是一个安全的连接。</p>
      <p>目标站点可以发送敏感数据,这可能是拦截时,代理将它发送回给你。
</p>
      <form action="includes/process.php" method="get">
         <input type="hidden" name="action" value="sslagree">
			<input type="submit" value="继续访问...">
         <input type="button" value="返回" onclick="window.location='.';">
		</form>
      <p>注意:这个警告将不会再出现。<br>
      </p>
	</div>
</body>
</html>