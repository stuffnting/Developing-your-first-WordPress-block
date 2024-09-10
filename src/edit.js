import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { store as coreDataStore } from "@wordpress/core-data";

import "./editor.scss";

import BookList from "./components/BookList";
import BlockControls from "./components/BlockControls";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const books = useSelect(
		(select) => select(coreDataStore).getEntityRecords("postType", "book"),
		[],
	);

	return (
		<div {...useBlockProps()}>
			<BlockControls attributes={attributes} setAttributes={setAttributes} />
			<p>{__("My Reading List – hello from the editor!", "my-reading-list")}</p>
			<BookList books={books} attributes={attributes} />
		</div>
	);
}
