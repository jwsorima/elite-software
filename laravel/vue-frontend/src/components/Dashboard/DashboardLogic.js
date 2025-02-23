import API from '../../api';
import { useRouter } from 'vue-router';

export default {
  data() {
    return {
      totalAlbums: [],
      topArtist: null,
      searchArtist: '',
      searchedAlbums: [],
      albums: [],
      artists: [],
      showArtistModal: false,
      showAlbumModal: false,
      isEditingArtist: false,
      isEditingAlbum: false,
      activeSection: 'artists', // Default to Manage Artists
      artistForm: { id: null, code: '', name: '' },
      albumForm: { id: null, artist_id: '', name: '', year: '', sales: '', cover_image: null }
    };
  },
  setup() {
    const router = useRouter();
    return { router };
  },
  async mounted() {
    await this.getDashboardData();
  },
  methods: {
    async getDashboardData() {
      try {
        const albumsResponse = await API.get('/dashboard/total-albums');
        this.totalAlbums = albumsResponse.data;

        const topArtistResponse = await API.get('/dashboard/top-artist');
        this.topArtist = topArtistResponse.data;

        const albumsData = await API.get('/albums');
        this.albums = albumsData.data;
        
        // Fetch all artists for the dropdown in Album Modal
        const artistsResponse = await API.get('/artists');
        this.artists = artistsResponse.data;
      } catch (error) {
        console.error('Error fetching data:', error.response?.data || error.message);
      }
    },
    async searchAlbums() {
      try {
        const response = await API.get('/dashboard/search-albums', {
          params: { artist: this.searchArtist }
        });
        this.searchedAlbums = response.data;
      } catch (error) {
        console.error('Error searching albums:', error.response?.data || error.message);
      }
    },
    async logout() {
      try {
        await API.post('/logout');
        localStorage.removeItem('token');
        this.router.push('/');
      } catch (error) {
        console.error('Logout failed:', error.response?.data || error.message);
      }
    },
    // Artist CRUD Operations
    async createArtist() {
      try {
        await API.post('/artists', this.artistForm);
        this.getDashboardData();
        this.closeArtistModal();
      } catch (error) {
        console.error('Error creating artist:', error.response?.data || error.message);
      }
    },
    async updateArtist() {
      try {
        await API.put(`/artists/${this.artistForm.id}`, this.artistForm);
        this.getDashboardData();
        this.closeArtistModal();
      } catch (error) {
        console.error('Error updating artist:', error.response?.data || error.message);
      }
    },
    async deleteArtist(id) {
      try {
        await API.delete(`/artists/${id}`);
        this.getDashboardData();
      } catch (error) {
        console.error('Error deleting artist:', error.response?.data || error.message);
      }
    },
    // Album CRUD Operations
    async createAlbum() {
      try {
        const formData = new FormData();
        formData.append('artist_id', this.albumForm.artist_id);
        formData.append('name', this.albumForm.name);
        formData.append('year', this.albumForm.year);
        formData.append('sales', this.albumForm.sales);
        
        if (this.albumForm.cover_image && this.albumForm.cover_image.name) {
          formData.append('cover_image', this.albumForm.cover_image);
        }
        
        await API.post('/albums', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });
        
        this.getDashboardData();
        this.closeAlbumModal();
      } catch (error) {
        console.error('Error creating album:', error.response?.data || error.message);
      }
    },    
    async updateAlbum() {
      try {
        const formData = new FormData();
        formData.append('artist_id', this.albumForm.artist_id);
        formData.append('name', this.albumForm.name);
        formData.append('year', this.albumForm.year);
        formData.append('sales', this.albumForm.sales);
    
        if (this.albumForm.cover_image instanceof File) {
          formData.append('cover_image', this.albumForm.cover_image);
        }
    
        await API.post(`/albums/${this.albumForm.id}?_method=PUT`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });
    
        this.getDashboardData();
        this.closeAlbumModal();
      } catch (error) {
        console.error('Error updating album:', error.response?.data || error.message);
      }
    },
    async deleteAlbum(id) {
      try {
        await API.delete(`/albums/${id}`);
        this.getDashboardData();
      } catch (error) {
        console.error('Error deleting album:', error.response?.data || error.message);
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.albumForm.cover_image = file;
      }
    },
    // Modal Handling for Artists
    openArtistModal(payload) {
      if (payload && payload.artist) {
        // Editing mode: copy artist data.
        this.artistForm = { ...payload.artist };
        this.isEditingArtist = true;
      } else {
        // Adding new artist.
        this.artistForm = { id: null, code: '', name: '' };
        this.isEditingArtist = false;
      }
      this.showArtistModal = true;
    },
    closeArtistModal() {
      this.showArtistModal = false;
      this.isEditingArtist = false;
      this.artistForm = { id: null, code: '', name: '' };
    },
    // Modal Handling for Albums
    openAlbumModal(payload) {
      if (payload && payload.album) {
        // Editing mode: copy album data and reset cover_image for file input.
        this.albumForm = { ...payload.album, cover_image: null };
        this.isEditingAlbum = true;
      } else {
        // Adding new album.
        this.albumForm = { id: null, artist_id: '', name: '', year: '', sales: '', cover_image: null };
        this.isEditingAlbum = false;
      }
      this.showAlbumModal = true;
    },
    closeAlbumModal() {
      this.showAlbumModal = false;
      this.isEditingAlbum = false;
      this.albumForm = { id: null, artist_id: '', name: '', year: '', sales: '', cover_image: null };
    }
  }
};
