<template>
      <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Mukta+Malar:wght@400;500&display=swap" rel="stylesheet">
<div class="frame-1">
    <div class="rectangle-3"></div>
    
    <form class="frame-12" id="registration-form">
      <!-- Логин -->
      <div class="input-form">
        <div class="label">
          <div class="text">
            <span class="label3">Логин</span>
          </div>
        </div>
        <div class="input-field">
          <img class="input-icon" src="/icons/user0.svg" alt="login">
          <input type="text" class="input-text" placeholder="Логин" name="login">
        </div>
      </div>

      <!-- Пароль -->
      <div class="input-form">
        <div class="label">
          <div class="text">
            <span class="label3">Пароль</span>
          </div>
        </div>
        <div class="input-field">
          <img class="input-icon" src="/icons/user0.svg" alt="password">
          <input type="password" class="input-text" placeholder="Пароль" name="password">
        </div>
      </div>

      <!-- Helper ссылка -->
      <div class="helper">
        Еще не зарегистрированы?<a href="#" class="helper-link" @click.prevent="changePage('RegPage')">Зарегистрируйтесь</a>
      </div>

      <!-- Кнопка -->
      <button type="submit" class="button">
        <span class="button-text">Авторизация</span>
      </button>
    </form>
  </div>
</template>
<script>
export default {
    props: ['datasend', 'PUBLIC', 'pageId', 'changePage'],
    data() {
        return {
            username: null,
            password: null,
            fullname: null,
            email: null,
            number: null,
            errors: {},
        };
    },
};
</script>