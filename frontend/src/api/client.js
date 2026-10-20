const BASE_URL = "/api";
const TOKEN_KEY = "epod_token";

export const getToken = () => localStorage.getItem(TOKEN_KEY);
export const setToken = (t) => (t ? localStorage.setItem(TOKEN_KEY, t) : localStorage.removeItem(TOKEN_KEY));

export async function request(path, { method = "GET", body } = {}) {
  const token = getToken();
  const res = await fetch(`${BASE_URL}${path}`, {
    method,
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
      ...(token && { Authorization: `Bearer ${token}` }),
    },
    body: body ? JSON.stringify(body) : undefined,
  });
  const json = await res.json().catch(() => null);
  if (!res.ok) {
    if (res.status === 401 && token) {
      setToken(null);
      window.location.assign("/login");
    }
    throw new Error(json?.message || `Request failed (${res.status})`);
  }
  // Backend answers { success, data, message }; pages only need the data.
  return json && "success" in json ? json.data : json;
}
