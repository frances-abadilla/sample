import { useEffect, useState } from "react";
import { getUsers, createUser, deleteUser } from "../api/users";

const empty = { name: "", username: "", password: "", role: "driver" };

export default function Users() {
  const [users, setUsers] = useState([]);
  const [form, setForm] = useState(empty);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(true);

  const load = () => getUsers().then(setUsers).catch((e) => setError(e.message)).finally(() => setLoading(false));
  useEffect(() => { load(); }, []);

  const change = (e) => setForm({ ...form, [e.target.name]: e.target.value });

  const save = async (e) => {
    e.preventDefault(); setError("");
    try { await createUser(form); setForm(empty); load(); }
    catch (err) { setError(err.message); }
  };
  const remove = async (u) => {
    if (!confirm(`Delete ${u.name}?`)) return;
    try { await deleteUser(u.id); load(); } catch (err) { setError(err.message); }
  };

  return (
    <>
      <h2 className="page-title">Users</h2>
      <form className="panel form-row" onSubmit={save}>
        <label>Name<input name="name" value={form.name} onChange={change} required /></label>
        <label>Username<input name="username" value={form.username} onChange={change} required /></label>
        <label>Password<input name="password" type="password" value={form.password} onChange={change} required /></label>
        <label>Role
          <select name="role" value={form.role} onChange={change}>
            <option value="driver">Driver</option>
            <option value="admin">Admin</option>
          </select>
        </label>
        <div className="actions"><button className="btn">Add user</button></div>
      </form>
      {error && <p className="error" role="alert">{error}</p>}
      {loading ? <p className="state">Loading…</p> : (
        <div className="table-wrap">
          <table>
            <thead><tr><th>Name</th><th>Username</th><th>Role</th><th /></tr></thead>
            <tbody>
              {users.map((u) => (
                <tr key={u.id}>
                  <td>{u.name}</td><td>{u.username}</td>
                  <td><span className={`badge ${u.role}`}>{u.role}</span></td>
                  <td className="row-actions"><button className="link danger" onClick={() => remove(u)}>Delete</button></td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </>
  );
}
