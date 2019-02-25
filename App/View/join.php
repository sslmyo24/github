	<section id="join-section">
		<h1 id="join-title">Join GitHub</h1>
		<p id="join-sub-title">The best way to design, build, and ship software.</p>
		<h2 id="join-des">Create your personal account</h2>
		<form method="post" id="join-form">
			<input type="hidden" name="action" value="join">
			<div class="name">Username <span>*</span></div>
			<input type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username'] ?>">
			<p class="des">This will be your username. You can add the name of your organization later.</p>
			<div class="name">Email address <span>*</span></div>
			<input type="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'] ?>">
			<p class="des">We’ll occasionally send updates about your account to this inbox. We’ll never share your email address with anyone.</p>
			<div class="name">Password <span>*</span></div>
			<input type="password" name="pw" value="<?php if (isset($_POST['pw'])) echo $_POST['pw'] ?>">
			<p class="des">Make sure it's more than 15 characters OR at least 8 characters including a number and a lowercase letter.</p>
			<div class="captcha">
				<img src="<?php echo HOME ?>/App/View/captcha.php" alt="captcha">
				<input type="text" name="captcha">
			</div>
			<button type="submit" disabled>Create an account</button>
		</form>
	</section>
</body>
</html>