<template>
  <DashboardTemplate
    :totalAlbums="totalAlbums"
    :topArtist="topArtist"
    :searchArtist="searchArtist"
    :searchedAlbums="searchedAlbums"
    :albums="albums"
    :activeSection="activeSection"
    :showArtistModal="showArtistModal"
    :showAlbumModal="showAlbumModal"
    :artistForm="artistForm"
    v-model:albumForm="albumForm"
    v-model:isEditingAlbum="isEditingAlbum"
    v-model:artistForm="artistForm"
    v-model:isEditingArtist="isEditingArtist"
    :artists="artists"
    @update:searchArtist="searchArtist = $event"
    @searchAlbums="searchAlbums"
    @update:activeSection="activeSection = $event"
    @openArtistModal="openArtistModal"
    @closeArtistModal="closeArtistModal"
    @openAlbumModal="openAlbumModal"
    @closeAlbumModal="closeAlbumModal"
    @logout="logout"
    @createArtist="createArtist"
    @updateArtist="updateArtist"
    @deleteArtist="deleteArtist"
    @createAlbum="createAlbum"
    @updateAlbum="updateAlbum"
    @deleteAlbum="deleteAlbum"
    @handleFileUpload="handleFileUpload"
  />
</template>

<script>
import DashboardTemplate from "../components/Dashboard/DashboardTemplate.vue";
import DashboardLogic from "../components/Dashboard/DashboardLogic.js";
import "../components/Dashboard/DashboardStyle.css";

export default {
  components: {
    DashboardTemplate,
  },
  ...DashboardLogic,
};
</script>
