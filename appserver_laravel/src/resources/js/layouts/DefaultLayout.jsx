import { Outlet } from 'react-router-dom';

function Layout() {
  return (
    <div className={"layout"} style={{padding: "0 3rem 0 3rem"}}>
        <Outlet /> {/* Acá se renderizarán los componentes de las rutas anidadas */}
    </div>
  );
};

export default Layout;
