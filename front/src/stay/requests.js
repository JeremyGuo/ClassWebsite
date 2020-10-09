import axios from 'axios';
  
axios.defaults.baseURL = "/api_server/index.php";
function setJWT(v) {
    axios.defaults.headers['Authorization'] = v;
}
function removeJWT() {
    delete axios.defaults.headers['Authorization'];
}
export default {
    setJWT,
    removeJWT,
    axios
}
