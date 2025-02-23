<template>
  <div class="home">
    <header class="header">
      <h1>Music Albums</h1>
      <nav>
        <router-link to="/login" class="login-link">Admin Login</router-link>
      </nav>
    </header>

    <div class="search-section">
      <input 
        type="text" 
        :value="searchArtist"
        placeholder="Search by artist name" 
        @input="$emit('update:searchArtist', $event.target.value)"
        @keyup.enter="$emit('search')"
      />
      <button @click="$emit('search')">Search</button>
    </div>

    <div class="albums-grid">
      <div v-for="album in albums" :key="album.id" class="album-card">
        <h3>{{ album.name }}</h3>
        <p>Artist: {{ album.artist ? album.artist.name : 'Unknown' }}</p>
        <p>Year: {{ album.year }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    albums: Array,
    searchArtist: String
  }
};
</script>
