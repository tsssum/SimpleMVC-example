<form method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('login/login')?>">
    
    <?php
    if (!empty($_GET['auth'])) {
        echo "Неверное имя пользователя или пароль";
    }
    ?>
    <div class="form-group">
        <label for="userName" >Username</label>
        <input type="text"  class="form-control" id="userName"  name="userName" >
    </div>
    <div class="form-group">
        <label for="password" >Password</label>
        <input type="password" name="password"  class="form-control" id="userName"  name="userName" >
    </div>
    <div class="buttons">
    <input type="submit" class="btn btn-primary" name="login" value="Войти">
    </div>
   
</form>

<style>
form {
  height: 180px;
  width:  500px;
  margin: 20px auto;
  padding: 40px 20px;
  overflow: auto;
  background: #fff4cf;
  border: 1px solid #666;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px; 
  border-radius: 5px;
  -moz-box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
  -webkit-box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
  box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
}
form * {
  line-height: 1em;
}

.form-group{
  margin: .9em 0 0 0;
  padding: 0;
}
label {
  display: block;
  float: left;
  clear: left;
  text-align: right;
  width: 15%;
  padding: .4em 0 0 0;
  margin: .105em .5em 0 0;
}
input, select, textarea {
  display: block;
  margin: 0;
  padding: .4em;
  width: 80%;
}

input, text, .date {
  border: 2px solid #666;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;   
  border-radius: 5px;
  background: #fff;
}

input {
  font-size: .9em;
}

select {
  padding: 0;
  margin-bottom: 2.5em;
  position: relative;
  top: .7em;
}

text {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  font-size: .9em;
  height: 5em;
  line-height: 1.5em;
}

text#content {
  font-family: "Courier New", courier, fixed;
}
.buttons {
  text-align: center;
  clear: both;
}

.btn-primary {
  display: inline-block;
  border: 2px solid #7c412b;
  border-radius: 5px;
  box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
  color: #fff;
  background: #ef7d50;
  font-weight: bold;
}

</style>
