<template>
      <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Mukta+Malar:wght@400;500&display=swap" rel="stylesheet">
<div class="frame-4">
    <!-- Шапка с аватаром пользователя -->
    <div class="avatar-label-group">
      <img class="avatar" src="/icons/avatar0.png" alt="avatar">
      <div class="text-and-supporting-text">
        <div class="user-name">ФИО пользователя</div>
        <div class="user-email">user@mail.com</div>
      </div>
    </div>

    <!-- Основной блок с услугой -->
    <div class="service-block">
      <h1 class="service-title">Услуга</h1>
      <div class="service-content">
        <div class="service-image-placeholder"></div>
        <img class="service-main-img" src="/icons/rectangle-30.png" alt="service image">
        <div class="service-description-bg"></div>
        <p class="service-description-text">Описание услуги. Здесь может быть подробная информация о предоставляемой услуге, её особенностях, стоимости и условиях.</p>
      </div>
    </div>

    <!-- Разделительная линия -->
    <div class="separator-line"></div>

    <!-- Блок с отзывами и формой -->
    <div class="reviews-section">
      <!-- Форма отправки отзыва -->
      <div class="review-form-container">
        <div class="form-label">
          <span class="form-label-text">Оставьте отзыв</span>
          <span class="required-star">*</span>
        </div>
        <div class="input-with-button">
          <div class="comment-input-field">
            <img class="input-icon" src="/icons/user0.svg" alt="user">
            <input type="text" class="comment-input" placeholder="Комментарий" name="comment">
            <img class="close-icon" src="/icons/close0.svg" alt="clear">
          </div>
          <button class="submit-button">
            <span class="submit-button-text">отправить</span>
          </button>
        </div>
      </div>

      <!-- Комментарий пользователя -->
      <div class="user-comment">
        <div class="comment-avatar-group">
          <img class="comment-avatar" src="/icons/avatar1.png" alt="user avatar">
          <div class="comment-user-info">
            <div class="comment-user-name">ФИО пользователя</div>
            <div class="comment-user-email">user@mail.com</div>
          </div>
        </div>
        <div class="comment-bubble"></div>
        <p class="comment-text">* Отличная услуга! Всё понравилось, буду рекомендовать друзьям.</p>
      </div>

      <!-- Блок лайков и ответа -->
       
      <div class="comment-actions">
        <button class="like-button">
          <img class="heart-icon" src="/icons/heart0.svg" alt="like">
        </button>
        <span class="likes-count">0</span>

        <div class="comment-input-field">
            <img class="input-icon" src="/icons/user0.svg" alt="user">
            <input type="text" class="comment-input" placeholder="Ответ" name="">
            <img class="close-icon" src="/icons/close0.svg" alt="clear">
          </div>

        <button class="reply-button">
          <span class="reply-button-text">Ответить</span>
        </button>
      </div>
    </div>
  </div>
</template>
<script>
name: 'ServPage'
</script>