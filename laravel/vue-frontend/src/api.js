import axios from 'axios';

const API = axios.create({
    baseURL: 'http://127.0.0.1:8000/api',
    withCredentials: true,
    headers: { 'Content-Type': 'application/json' }
});

export const getCsrfToken = async () => {
  try {
    await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie', { withCredentials: true });
  } catch (error) {
    console.error("CSRF Token Fetch Error:", error);
  }
};

API.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

export default API;
