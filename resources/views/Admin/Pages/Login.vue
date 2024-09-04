<template>
  <div class="login-page">
    <form action="" class="login-form d-none d-lg-block">
      <div class="row">
        <div class="col-lg-3 mb-3">
          <label for="inputUserName" class="form-label col-form-label">User Name</label>
        </div>
        <div class="col-lg-9 mb-3">
          <input id="inputUserName" type="text" class="form-control" placeholder="User Name ">
        </div>
        <div class="col-lg-3 mb-3">
          <label for="inputUserName" class="form-label col-form-label">Password</label>
        </div>
        <div class="col-lg-9 mb-3">
          <input id="inputUserName" type="text" class="form-control" placeholder="Password">
        </div>
        <div class="col-lg-3 mb-3">
          <label for="inputUserName" class="form-label col-form-label">Password Confirm</label>
        </div>
        <div class="col-lg-9 mb-3">
          <input id="inputUserName" type="text" class="form-control" placeholder="Password Confirm">
        </div>
        <div class="col-lg-3 mb-3"></div>
        <div class="col-lg-9 mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck1">
            <label class="form-check-label" for="gridCheck1">
              Remember Me For 30 Days !
            </label>
          </div>
        </div>
        <div class="col-lg-3 mb-3"></div>
        <div class="col-lg-9 mb-3">
          <div class="row">
            <p class="col-lg-4 col-sm-12">Forget password</p>
            <p class="col-lg-2 col-sm-12 text-center"><span>Or</span></p>
            <p class="col-lg-4 col-sm-12">Register</p>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100">Sign in</button>
    </form>
    <form action="" class="login-form-sm d-lg-none d-sm-block">
      <div class="row">
        <div class="col-12 mb-3">
          <label for="inputUserName" class="form-label col-form-label">User Name</label>
        </div>
        <div class="col-sm-12 mb-3">
          <input id="inputUserName" type="text" class="form-control" placeholder="User Name ">
        </div>
        <div class="col-sm-12 mb-3">
          <label for="inputUserName" class="form-label col-form-label">Password</label>
        </div>
        <div class="col-sm-12 mb-3">
          <input id="inputUserName" type="text" class="form-control" placeholder="Password">
        </div>
        <div class="col-lg-3 mb-3">
          <label for="inputUserName" class="form-label col-form-label">Password Confirm</label>
        </div>
        <div class="col-sm-12 mb-3">
          <input id="inputUserName" type="text" class="form-control" placeholder="Password Confirm">
        </div>
        <div class="col-sm-12 mb-3"></div>
        <div class="col-sm-12 mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
              Remember Me For 30 Days !
            </label>
          </div>
        </div>
        <div class="col-sm-12 mb-3"></div>
        <div class="col-sm-12 mb-3">
          <div class="d-flex flex-column">
            <span class="mb-3">Forget password</span>
            <span class="mb-3">Or</span>
            <span class="mb-3">Register</span>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100">Sign in</button>
    </form>
  </div>
</template>

<script>
export default {

}
</script>

<style>
.login-page{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100vw;
  background-color: rgb(170, 170, 170);
}
.login-form{
  width: 50%;
  padding: 24px;
  border-radius: 8px;
  background-color: white
}
.login-form-sm{
  width: 100%;
  height: 100%;
  padding: 24px;
  background-color: white
}
p{
  margin-bottom: 0;
}
p:first-child{
  border-right: 1px solid black;
  padding-right: 24px;
}
p:last-child{
  border-left: 1px solid black;
  padding-left: 24px;
}
p:first-child:hover{
  cursor: pointer;
  color: rgb(13, 110, 253);
}
p:last-child:hover{
  cursor: pointer;
  color: rgb(13, 110, 253);
}

@media (max-width: 1281px) {
  .login-form{
    width: 70%;
  }
}
</style>