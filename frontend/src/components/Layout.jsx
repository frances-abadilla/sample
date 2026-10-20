import { NavLink, Outlet, useNavigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

export default function Layout() {
  const { user, logout } = useAuth();
  const navigate = useNavigate();
  const signOut = () => { logout(); navigate("/login"); };

  return (
    <div className="shell">
      <aside className="sidebar">
        <div className="brand">EPOD<span>Store Visit</span></div>
        <nav>
          <NavLink to="/" end>Dashboard</NavLink>
          <NavLink to="/stores">Stores</NavLink>
          <NavLink to="/users">Users</NavLink>
        </nav>
        <div className="sidebar-foot">
          <p>{user.name}</p>
          <button className="btn btn-ghost" onClick={signOut}>Sign out</button>
        </div>
      </aside>
      <main className="content"><Outlet /></main>
    </div>
  );
}
