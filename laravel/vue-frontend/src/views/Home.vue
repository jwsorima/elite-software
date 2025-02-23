<template>
  <HomeTemplate
    :albums="albums"
    :searchArtist="searchArtist"
    @search="searchAlbums"
  />
</template>

<script>
import HomeTemplate from "../components/Home/HomeTemplate.vue";
import HomeLogic from "../components/Home/HomeLogic.js";
import "../components/Home/HomeStyle.css";

export default {
  components: {
    HomeTemplate,
  },
  ...HomeLogic,
};
</script>
