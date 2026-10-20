import { useEffect, useState } from "react";
import { getStores } from "../api/stores";
import { getUsers } from "../api/users";

export default function Dashboard() {
  const [stats, setStats] = useState(null);
  const [error, setError] = useState("");

  useEffect(() => {
    Promise.all([getStores(), getUsers()])
      .then(([stores, users]) =>
        setStats({
          stores: stores.length,
          active: stores.filter((s) => s.status === "active").length,
          drivers: users.filter((u) => u.role === "driver").length,
          admins: users.filter((u) => u.role === "admin").length,
        }))
      .catch((e) => setError(e.message));
  }, []);

  if (error) return <p className="error">{error}</p>;
  if (!stats) return <p className="state">Loading…</p>;

  const items = [
    ["Stores", stats.stores], ["Active stores", stats.active],
    ["Drivers", stats.drivers], ["Admins", stats.admins],
  ];
  return (
    <>
      <h2 className="page-title">Dashboard</h2>
      <div className="stats">
        {items.map(([label, value]) => (
          <div className="stat" key={label}><strong>{value}</strong><span>{label}</span></div>
        ))}
      </div>
    </>
  );
}
