import React from 'react';
import {useParams} from "react-router-dom";

export default function Quiz() {
    let { hash } = useParams();

    return (
        <div>
            <h2>Quiz: {hash}</h2>
        </div>
    );
}

