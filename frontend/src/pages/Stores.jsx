import { useEffect, useState } from "react";
import { getStores, createStore, updateStore, deleteStore } from "../api/stores";

const empty = { name: "", code: "", address: "", status: "active" };

export default function Stores() {
  const [stores, setStores] = useState([]);
  const [form, setForm] = useState(empty);
  const [editingId, setEditingId] = useState(null);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(true);

  const load = () => getStores().then(setStores).catch((e) => setError(e.message)).finally(() => setLoading(false));
  useEffect(() => { load(); }, []);

  const change = (e) => setForm({ ...form, [e.target.name]: e.target.value });
  const reset = () => { setForm(empty); setEditingId(null); };

  const save = async (e) => {
    e.preventDefault(); setError("");
    try {
      editingId ? await updateStore(editingId, form) : await createStore(form);
      reset(); load();
    } catch (err) { setError(err.message); }
  };

  const edit = (s) => { setEditingId(s.id); setForm({ name: s.name, code: s.code, address: s.address, status: s.status }); };
  const remove = async (s) => {
    if (!confirm(`Delete ${s.name}?`)) return;
    try { await deleteStore(s.id); load(); } catch (err) { setError(err.message); }
  };

  return (
    <>
      <h2 className="page-title">Stores</h2>
      <form className="panel form-row" onSubmit={save}>
        <label>Name<input name="name" value={form.name} onChange={change} required /></label>
        <label>Code<input name="code" value={form.code} onChange={change} required /></label>
        <label>Address<input name="address" value={form.address} onChange={change} /></label>
        <label>Status
          <select name="status" value={form.status} onChange={change}>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </label>
        <div className="actions">
          <button className="btn">{editingId ? "Save changes" : "Add store"}</button>
          {editingId && <button type="button" className="btn btn-ghost" onClick={reset}>Cancel</button>}
        </div>
      </form>
      {error && <p className="error" role="alert">{error}</p>}
      {loading ? <p className="state">Loading…</p> : stores.length === 0 ? (
        <p className="state">No stores yet. Add your first store above.</p>
      ) : (
        <div className="table-wrap">
          <table>
            <thead><tr><th>Name</th><th>Code</th><th>Address</th><th>Status</th><th /></tr></thead>
            <tbody>
              {stores.map((s) => (
                <tr key={s.id}>
                  <td>{s.name}</td><td>{s.code}</td><td>{s.address}</td>
                  <td><span className={`badge ${s.status}`}>{s.status}</span></td>
                  <td className="row-actions">
                    <button className="link" onClick={() => edit(s)}>Edit</button>
                    <button className="link danger" onClick={() => remove(s)}>Delete</button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </>
  );
}
