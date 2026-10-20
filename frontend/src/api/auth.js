import { request, setToken } from "./client";

export async function login(username, password) {
  const data = await request("/auth/login", { method: "POST", body: { username, password } });
  setToken(data.token);
  return data.user;
}
export const logout = () => setToken(null);
export const getMe = () => request("/auth/me");
