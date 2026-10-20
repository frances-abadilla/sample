import { request } from "./client";

export const getStores = () => request("/stores");
export const createStore = (s) => request("/stores", { method: "POST", body: s });
export const updateStore = (id, s) => request(`/stores/${id}`, { method: "PUT", body: s });
export const deleteStore = (id) => request(`/stores/${id}`, { method: "DELETE" });
