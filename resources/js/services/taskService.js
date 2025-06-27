import axios from 'axios';

axios.defaults.baseURL = '/api';

export default {
  async list() {
    const { data } = await axios.get('/tasks');
    return data;
  },
  async create(task) {
    const { data } = await axios.post('/tasks', task);
    return data;
  },
  async update(id, task) {
    const { data } = await axios.put(`/tasks/${id}`, task);
    return data;
  },
  async delete(id) {
    await axios.delete(`/tasks/${id}`);
  },
  async toggle(id) {
    const { data } = await axios.patch(`/tasks/${id}/toggle`);
    return data;
  }
};
