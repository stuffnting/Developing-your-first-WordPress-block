import { Panel, PanelBody, ToggleControl } from "@wordpress/components";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
export default function BookList({ attributes, setAttributes }) {
	const { showContent, showImage } = attributes;
	return (
		<InspectorControls key="setting">
			<Panel>
				<PanelBody title="My Reading List Settings">
					<ToggleControl
						label="Toggle Image"
						checked={showImage}
						onChange={(newValue) => {
							setAttributes({ showImage: newValue });
						}}
					/>
					<ToggleControl
						label="Toggle Content"
						checked={showContent}
						onChange={(newValue) => {
							setAttributes({ showContent: newValue });
						}}
					/>
				</PanelBody>
			</Panel>
		</InspectorControls>
	);
}
