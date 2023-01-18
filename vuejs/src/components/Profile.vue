<template>
  <section class="profile-container">
    <div class="profile-header">
      <img class="profile-picture" :src="profile.picture" >
      <div class="profile-name">Jean Paul</div>
    </div>
    <div class="profile-details">
      <div class="profile-detail">jp96@test.fr</div>
      <div class="profile-detail">Paris</div>
    </div>
  </section>
  <section class="theater-list">
    <h2 class="theater-title">Mes séances</h2>
    <div class="theater-card">
      <div class="theater-card-header">
        <div class="theater-card-title">Theater 1</div>
        <div class="theater-card-subtitle">Address 1</div>
      </div>
      <div class="theater-card-body">
        <div class="theater-card-body-item">Movie 1</div>
        <div class="theater-card-body-item">Movie 2</div>
        <div class="theater-card-body-item">Movie 3</div>
      </div>
    </div>
    <div class="theater-card">
      <div class="theater-card-header">
        <div class="theater-card-title">Theater 2</div>
        <div class="theater-card-subtitle">Address 2</div>
      </div>
      <div class="theater-card-body">
        <div class="theater-card-body-item">Movie 1</div>
        <div class="theater-card-body-item">Movie 2</div>
        <div class="theater-card-body-item">Movie 3</div>
      </div>
    </div>
  </section>
  <section class="ticket">
    <h2 class="ticket-title">Mes billets</h2>
    <div class="ticket-card-header">
        <div class="ticket-card-title">Theater 2</div>
        <div class="ticket-card-subtitle">QR Code</div>
      </div>
  </section>
</template>

<script>
import axios from 'axios'
export default {
  data () {
    return {
      profile: {}
    }
  },
  created () {
    axios.get('https://www.shutterstock.com/image-vector/man-icon-vector-260nw-1040084344.jpg')
      .then(response => {
        this.profile = response.data
      })
  }
}
</script>

<style>
.profile-container {
  margin-top : 16px;
  background-color: beige;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.profile-header {
  margin : 15px;
  display: flex;
  align-items: center;
  margin-bottom: 16px;
}

.profile-picture {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  margin-right: 16px;
  border: 2px solid #000;
}

.profile-name {
  font-size: 24px;
  font-weight: bold;
}

.profile-details {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.profile-detail {
  font-size: 18px;
  margin: 0 8px;
}

.theater-title {
  margin-top: 16px;
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 16px;
  /* align center text */
  text-align: center;
  width: 100%;
}

.theater-list {
  margin-top: 16px;
  background-color: beige;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.theater-card {
  width: 300px;
  height: 300px;
  margin: 16px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
}

.theater-card-header {
  padding: 16px;
  border-bottom: 1px solid #ccc;
}

.theater-card-title {
  font-size: 24px;
  font-weight: bold;
}

.theater-card-subtitle {
  font-size: 18px;
}

.theater-card-body {
  padding: 16px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.theater-card-body-item {
  font-size: 18px;
  margin-bottom: 8px;
}

.ticket {
  margin-top: 16px;
  background-color: beige;
  width: 100%;
}

.ticket-title {
  text-align: center;
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 16px;
}

.ticket-card-header {
  padding: 16px;
  border-bottom: 1px solid #ccc;
}

.ticket-card-title {
  font-size: 24px;
  font-weight: bold;
}

.ticket-card-subtitle {
  font-size: 18px;
}

.ticket-card-body {
  padding: 16px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.ticket-card-body-item {
  font-size: 18px;
  margin-bottom: 8px;
}


</style>
