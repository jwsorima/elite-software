<template>
  <div class="dashboard-wrapper">
    <header class="dashboard-header">
      <h2>Admin Dashboard</h2>
      <button @click="$emit('logout')" class="logout-button">Logout</button>
    </header>

    <!-- Stats Section -->
    <div class="dashboard-grid">
      <div class="stat-card">
        <h3>Total Artists</h3>
        <div class="stat-value">{{ totalAlbums.length }}</div>
      </div>
      <div class="stat-card">
        <h3>Total Albums</h3>
        <div class="stat-value">
          {{ totalAlbums.reduce((sum, artist) => sum + artist.albums_count, 0) }}
        </div>
      </div>
      <div class="stat-card">
        <h3>Top Artist</h3>
        <div v-if="topArtist" class="stat-content">
          <div class="stat-value">{{ topArtist.name }}</div>
          <div class="stat-subtitle">
            {{ topArtist.albums_sum_sales.toLocaleString() }} sales
          </div>
        </div>
      </div>
    </div>

    <!-- Search Albums -->
    <div class="dashboard-section">
      <h3>Search Albums</h3>
      <div class="search-controls">
        <input
          :value="searchArtist"
          placeholder="Enter artist name"
          @input="$emit('update:searchArtist', $event.target.value)"
          @keyup.enter="$emit('searchAlbums')"
        />
        <button @click="$emit('searchAlbums')" class="search-button">Search</button>
      </div>
      <div class="results-grid" v-if="searchedAlbums.length">
        <div v-for="album in searchedAlbums" :key="album.id" class="album-card">
          <h4>{{ album.name }}</h4>
          <p class="album-year">{{ album.year }}</p>
          <p class="album-sales">{{ album.sales.toLocaleString() }} sales</p>
        </div>
      </div>
      <p v-else class="no-results">No albums found</p>
    </div>

    <!-- Toggle Section -->
    <div class="toggle-section">
      <button
        @click="$emit('update:activeSection', 'artists')"
        :class="{ active: activeSection === 'artists' }"
      >
        Manage Artists
      </button>
      <button
        @click="$emit('update:activeSection', 'albums')"
        :class="{ active: activeSection === 'albums' }"
      >
        Manage Albums
      </button>
    </div>

    <!-- Manage Artists Section -->
    <div v-if="activeSection === 'artists'" class="dashboard-section">
      <h3>Manage Artists</h3>
      <!-- Emit payload with artist: null, editing: false -->
      <button class="add-button" @click="$emit('openArtistModal', { artist: null, editing: false })">
        + Add Artist
      </button>
      <div class="artists-grid">
        <div v-for="artist in totalAlbums" :key="artist.id" class="artist-card">
          <h4>{{ artist.name }}</h4>
          <p>{{ artist.albums_count }} albums</p>
          <div class="actions">
            <!-- Emit payload with artist data and editing true -->
            <button class="edit-button" @click="$emit('openArtistModal', { artist: artist, editing: true })">
              Edit
            </button>
            <button class="delete-button" @click="$emit('deleteArtist', artist.id)">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Manage Albums Section -->
    <div v-if="activeSection === 'albums'" class="dashboard-section">
      <h3>Manage Albums</h3>
      <!-- Emit payload for add: album null and editing false -->
      <button class="add-button" @click="$emit('openAlbumModal', { album: null, editing: false })">
        + Add Album
      </button>
      <div class="albums-grid">
        <div v-for="album in albums" :key="album.id" class="album-card">
          <img v-if="album.cover_image" :src="album.cover_image" alt="Album Cover" />
          <h4>{{ album.name }}</h4>
          <p>{{ album.year }}</p>
          <p>{{ album.sales.toLocaleString() }} sales</p>
          <div class="actions">
            <!-- Emit payload with album data and editing flag true -->
            <button class="edit-button" @click="$emit('openAlbumModal', { album: album, editing: true })">
              Edit
            </button>
            <button class="delete-button" @click="$emit('deleteAlbum', album.id)">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Artist Modal -->
    <div v-if="showArtistModal" class="modal-overlay">
      <div class="modal">
        <h3>{{ isEditingArtist ? "Edit Artist" : "Add Artist" }}</h3>
        <div class="input-label">
          <span>Artist Code:</span>
          <input
            :value="artistForm.code"
            placeholder="Artist Code"
            @input="$emit('update:artistForm', { ...artistForm, code: $event.target.value })"
          />
        </div>
        <div class="input-label">
          <span>Artist Name:</span>
          <input
            :value="artistForm.name"
            placeholder="Artist Name"
            @input="$emit('update:artistForm', { ...artistForm, name: $event.target.value })"
          />
        </div>
        <div class="modal-actions">
          <button @click="$emit(isEditingArtist ? 'updateArtist' : 'createArtist')">Save</button>
          <button @click="$emit('closeArtistModal')">Cancel</button>
        </div>
      </div>
    </div>

    <!-- Album Modal -->
    <div v-if="showAlbumModal" class="album-modal-overlay">
      <div class="album-modal">
        <h3>{{ isEditingAlbum ? "Edit Album" : "Add Album" }}</h3>
        <!-- Artist Dropdown -->
        <div class="album-input-group" data-label="Artist:">
          <select
            :value="albumForm.artist_id"
            @change="$emit('update:albumForm', { ...albumForm, artist_id: $event.target.value })"
          >
            <option value="">Select Artist</option>
            <option v-for="artist in artists" :key="artist.id" :value="artist.id">
              {{ artist.name }}
            </option>
          </select>
        </div>
        <div class="album-input-group" data-label="Album Name:">
          <input
            :value="albumForm.name"
            placeholder="Album Name"
            @input="$emit('update:albumForm', { ...albumForm, name: $event.target.value })"
          />
        </div>
        <div class="album-input-group" data-label="Year:">
          <input
            :value="albumForm.year"
            type="number"
            placeholder="Year"
            @input="$emit('update:albumForm', { ...albumForm, year: $event.target.value })"
          />
        </div>
        <div class="album-input-group" data-label="Sales:">
          <input
            :value="albumForm.sales"
            type="number"
            placeholder="Sales"
            @input="$emit('update:albumForm', { ...albumForm, sales: $event.target.value })"
          />
        </div>
        <div class="album-input-group" data-label="Cover Image:">
          <input type="file" @change="$emit('handleFileUpload', $event)" />
        </div>
        <div class="album-modal-actions">
          <button class="save-button" @click="$emit(isEditingAlbum ? 'updateAlbum' : 'createAlbum')">
            Save
          </button>
          <button class="cancel-button" @click="$emit('closeAlbumModal')">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    "totalAlbums",
    "topArtist",
    "searchArtist",
    "searchedAlbums",
    "albums",
    "activeSection",
    "showArtistModal",
    "showAlbumModal",
    "artistForm",
    "albumForm",
    "isEditingArtist",
    "isEditingAlbum",
    "artists",
  ],
};
</script>
