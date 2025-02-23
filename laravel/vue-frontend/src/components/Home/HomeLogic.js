import API from "../../api";

export default {
  data() {
    return {
      albums: [],
      searchArtist: "",
    };
  },
  async mounted() {
    this.loadAlbums();
  },
  methods: {
    async loadAlbums() {
      try {
        const response = await API.get("/albums");
        this.albums = response.data;
      } catch (error) {
        console.error("Failed to load albums:", error);
      }
    },
    async searchAlbums() {
      try {
        const response = await API.get("/dashboard/search-albums", {
          params: { artist: this.searchArtist },
        });
        this.albums = response.data;
      } catch (error) {
        console.error("Search failed:", error);
      }
    },
  },
};
