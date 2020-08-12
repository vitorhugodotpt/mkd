import React from 'react';

class Table extends React.Component {
    render() {
        const list = this.props.rows.map((row) =>
            <div key={row.title} className="media text-muted pt-3">
                <div className="media-body pb-3 mb-0 lh-125 border-bottom border-gray">
                    <div className="d-flex small justify-content-between align-items-center w-100">
                        <strong className="text-gray-dark">{row.title}</strong>
                        <span className="badge badge-primary">{row.value}</span>
                    </div>
                </div>
            </div>
        );

        return (
            <div>
                <div className="my-3 p-3 bg-white rounded shadow-sm">
                    <h6 className="border-bottom border-gray pb-2 mb-0">{this.props.title}</h6>
                    {list}
                </div>
            </div>
        );
    }
}
export default Table;
