import { request } from "./client";

export const getUsers = () => request("/users");
export const createUser = (u) => request("/users", { method: "POST", body: u });
export const deleteUser = (id) => request(`/users/${id}`, { method: "DELETE" });
