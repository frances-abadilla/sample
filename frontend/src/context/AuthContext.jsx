import { createContext, useContext, useEffect, useState } from "react";
import * as authApi from "../api/auth";
import { getToken } from "../api/client";

const AuthContext = createContext(null);
export const useAuth = () => useContext(AuthContext);

export function AuthProvider({ children }) {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(Boolean(getToken()));

  useEffect(() => {
    if (!getToken()) return;
    authApi.getMe().then(setUser).catch(() => authApi.logout()).finally(() => setLoading(false));
  }, []);

  const login = async (username, password) => setUser(await authApi.login(username, password));
  const logout = () => { authApi.logout(); setUser(null); };

  return <AuthContext.Provider value={{ user, loading, login, logout }}>{children}</AuthContext.Provider>;
}
